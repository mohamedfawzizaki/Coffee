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
    
            $exists = UnregisteredCustomer::where('phone', $customer->phone)->first();
    
            if (!$exists) {
                return true;
            }
    
            $customer->increment('points', $exists->points);
    
            CustomerPoint::create([
                'customer_id' => $customer->id,
                'amount' => $exists->points,
                'type' => 'in',
                'ar_content' => 'تم إضافة النقاط من الطلبات الفوديكس',
                'en_content' => 'Points Added From Foodics Orders',
            ]);
    
            $exists->delete();
    
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
