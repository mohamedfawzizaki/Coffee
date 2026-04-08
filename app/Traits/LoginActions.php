<?php

namespace App\Traits;

use App\Models\Customer\CustomerPoint;
use App\Models\Customer\DailyLogin;
use App\Models\Customer\UnregisteredCustomer;
use App\Models\General\Setting;
use Illuminate\Support\Facades\Log;
trait LoginActions
{
    /*
    Add Daily Login Points to Customer
@paramCustomer$customer
@returnbool
    */
    public function dailyLogin($customer)
    {
        try {
            $exists = DailyLogin::where('customer_id', $customer->id)->where('date', now()->format('Y-m-d'))->first();

            if (!$exists) {
                $dailyLoginPoint = customerActionPoints($customer->id, 'login');

                if ($dailyLoginPoint <= 0) {
                    return true;
                }

                // Create Daily Login Points
                DailyLogin::create([
                    'customer_id' => $customer->id,
                    'date' => now()->format('Y-m-d'),
                    'points' => $dailyLoginPoint,
                ]);

                // Update Customer Points
                $customer->update([
                    'points' => $customer->points + $dailyLoginPoint,
                ]);


                // Create Customer Points
                CustomerPoint::create([
                    'customer_id' => $customer->id,
                    'amount' => $dailyLoginPoint,
                    'type' => 'in',
                    'ar_content' => 'نقاط التسجيل اليومي',
                    'en_content' => 'Daily Login Points',
                ]);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to add daily login points: ' . $e->getMessage());
            return false;
        }
    }

    public function registerPoints($customer)
    {
        try {
    
            $firstRegisterPoint = customerActionPoints($customer->id, 'register');
    
            if ($firstRegisterPoint <= 0) {
                return true;
            }
    
            $customer->increment('points', $firstRegisterPoint);
    
            CustomerPoint::create([
                'customer_id' => $customer->id,
                'amount' => $firstRegisterPoint,
                'type' => 'in',
                'ar_content' => 'تم التسجيل للمرة الأولى',
                'en_content' => 'Registered for the first time',
            ]);
    
            return true;
    
        } catch (\Exception $e) {
    
            Log::error('Failed to add register points: ' . $e->getMessage(), [
                'customer_id' => $customer->id,
                'email' => $customer->email,
            ]);
    
            return false;
        }
    }

    public function registerFoodicsPoints($customer)
    {
        try {
            $normalizedPhone = normalizePhone($customer->phone);

            // Try to find the aggregated unregistered record (used as a quick existence check)
            $exists = UnregisteredCustomer::where(function ($q) use ($normalizedPhone) {
                $q->where('phone', $normalizedPhone)
                  ->orWhere('phone', '0' . $normalizedPhone)
                  ->orWhere('phone', '966' . $normalizedPhone)
                  ->orWhere('phone', '+966' . $normalizedPhone)
                  ->orWhereRaw("TRIM(LEADING '0' FROM REPLACE(REPLACE(REPLACE(REPLACE(phone, '+966', ''), '966', ''), ' ', ''), '-', '')) = ?", [$normalizedPhone]);
            })->first();

            if (!$exists) {
                return true;
            }

            // ------------------------------------------------------------------
            // PRIMARY: fetch per-order rows from the foodics table and create
            // one CustomerPoint per order so every record has an order_id.
            // ------------------------------------------------------------------
            $foodicsOrders = \App\Models\Foodics\Foodics::where(function ($q) use ($normalizedPhone) {
                $q->where('phone', $normalizedPhone)
                  ->orWhere('phone', '0' . $normalizedPhone)
                  ->orWhere('phone', '966' . $normalizedPhone)
                  ->orWhere('phone', '+966' . $normalizedPhone)
                  ->orWhereRaw("TRIM(LEADING '0' FROM REPLACE(REPLACE(REPLACE(REPLACE(phone, '+966', ''), '966', ''), ' ', ''), '-', '')) = ?", [$normalizedPhone]);
            })->whereNull('customer_id')->get();

            if ($foodicsOrders->isNotEmpty()) {
                $totalPoints = 0;

                foreach ($foodicsOrders as $foodicsOrder) {
                    $points = (int) round($foodicsOrder->points ?? 0);
                    if ($points <= 0) {
                        $points = (int) round(customerMoneyToPoint($customer->id, (float) ($foodicsOrder->total_price ?? 0)));
                    }

                    if ($points <= 0) {
                        continue;
                    }

                    \App\Models\Customer\CustomerPoint::create([
                        'customer_id' => $customer->id,
                        'order_id'    => $foodicsOrder->id,   // ← linked per order
                        'order_type'  => 'foodics',
                        'amount'      => $points,
                        'type'        => 'in',
                        'ar_content'  => 'تم إضافة النقاط من الطلبات الفوديكس',
                        'en_content'  => 'Points Added From Foodics Orders',
                    ]);

                    // Mark Foodics row as claimed by this customer
                    $foodicsOrder->update(['customer_id' => $customer->id]);

                    $totalPoints += $points;
                }

                if ($totalPoints > 0) {
                    $customer->increment('points', $totalPoints);
                    $exists->delete();
                } else {
                    // Keep backward compatibility by preserving already aggregated points.
                    if ((int) $exists->points > 0) {
                        $customer->increment('points', $exists->points);

                        \App\Models\Customer\CustomerPoint::create([
                            'customer_id' => $customer->id,
                            'amount'      => $exists->points,
                            'type'        => 'in',
                            'ar_content'  => 'تم إضافة النقاط من الطلبات الفوديكس',
                            'en_content'  => 'Points Added From Foodics Orders',
                        ]);
                    }

                    $exists->delete();
                }

            } else {
                // ------------------------------------------------------------------
                // FALLBACK: no per-order Foodics rows found (old data before this fix).
                // Use the aggregated unregistered points total — still no order_id but
                // at least existing data keeps working.
                // ------------------------------------------------------------------

            $customer->increment('points', $exists->points);

                \App\Models\Customer\CustomerPoint::create([
                    'customer_id' => $customer->id,
                    'amount'      => $exists->points,
                    'type'        => 'in',
                    'ar_content'  => 'تم إضافة النقاط من الطلبات الفوديكس',
                    'en_content'  => 'Points Added From Foodics Orders',
                ]);

                $exists->delete();
            }

            return true;

        } catch (\Exception $e) {

            Log::error('Failed to add register foodics points: ' . $e->getMessage());

            return false;
        }
    }

    public function registerReferralPoints($customer)
    {
        try {
    
            $referalPoint = customerActionPoints($customer->id, 'referral');
    
            if ($referalPoint <= 0) {
                return true;
            }
    
            $customer->increment('points', $referalPoint);
    
            CustomerPoint::create([
                'customer_id' => $customer->id,
                'amount' => $referalPoint,
                'type' => 'in',
                'ar_content' => 'تم إضافة النقاط من الإحالة',
                'en_content' => 'Points Added From Referral',
            ]);
    
            return true;
    
        } catch (\Exception $e) {
    
            Log::error('Failed to add referal points: ' . $e->getMessage());
    
            return false;
        }
    }
}
