<?php

use App\Models\Branch\Branch;
use App\Models\Branch\BranchProduct;
use App\Models\Branch\Worktime;
use App\Models\Customer\Customer;
use App\Models\Customer\Favourite;
use App\Models\CustomerCard\CustomerCard;
use App\Models\Product\Product\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

function roleModel()
{
    $roles = config('laratrust_seeder.roles_structure.superadmin');

    $roleModel = [];

    foreach ($roles as $key => $value) {
        if ($key == 'admin') {
            if (auth('admin')->check() && auth('admin')->user()->email == 'admin@syntech.com') {
                $roleModel[] = $key;
            }
            continue;
        }
        $roleModel[] = $key;
    }

    return $roleModel;
}


function storeRoleModel()
{
      $roles =  config('laratrust_seeder.roles_structure.store');

        $roleModel = [];

        foreach ($roles as $key => $value) {

            $roleModel[] = $key;

        }

        return $roleModel;
}


function roleMap()
{
      return [
        'create',
        'read',
        'update',
        'delete'
      ];
}

function branchToday($id)
{
    $branch = Branch::find($id);

    if (!$branch || !$branch->status) {   return null;  }

    $today = strtolower(Carbon::now()->format('l'));

    $worktime = Worktime::whereRaw('LOWER(day) = ?', [$today])
        ->where('branch_id', $id)
        ->first();

    if (!$worktime) {  return null;  }

    $all_day = $worktime->all_day;

    if ($all_day) {
        return $worktime;
    }

    return $worktime;
}

function branchOpen($id)
{
    $branch = Branch::find($id);

    if (!$branch || !$branch->status) {
        return __('Closed');
    }

    $timezone = 'Asia/Riyadh';
    $now = Carbon::now($timezone);
    $today = strtolower($now->format('l'));

    $worktime = Worktime::whereRaw('LOWER(day) = ?', [$today])
        ->where('branch_id', $id)
        ->where('status', true)
        ->first();

    if (!$worktime) {
        return __('Closed');
    }

    if ($worktime->all_day) {
        return __('Open');
    }

    $fromTime = Carbon::createFromFormat('H:i:s', $worktime->from, $timezone);
    $toTime = Carbon::createFromFormat('H:i:s', $worktime->to, $timezone);

    $fromTime->setDate($now->year, $now->month, $now->day);
    $toTime->setDate($now->year, $now->month, $now->day);

    if ($toTime->lessThan($fromTime)) {
        $toTime->addDay();
    }

    return ($now->greaterThanOrEqualTo($fromTime) && $now->lessThanOrEqualTo($toTime))
        ? __('Open')
        : __('Closed');
}

function branchFaved($id)
{
     if(Auth::guard('mobile')->check()){

        $favourite = Favourite::where('type', 'branch')
        ->where('type_id', $id)
        ->where('customer_id', Auth::user()->id)
        ->first();

        return $favourite ? true : false;
     }

     return false;
}

function branchProduct($id)
{
    $product = Product::find($id);

    if(!$product) { return false; }

     $branch_id = Auth::guard('cashier')->check() ? Auth::user()->branch_id : null;

    $exists = BranchProduct::where('branch_id', $branch_id)->where('product_id', $id)->first();

    if(!$exists) { return false; }

    return $exists->status ? true : false;
}



   function calculateDistance($currentLat, $currentLng, $branchLat, $branchLng)
    {
        $earthRadius = 6371000; // Radius of the earth in meters

        $dLat = deg2rad($branchLat - $currentLat);

        $dLng = deg2rad($branchLng - $currentLng);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($currentLat)) * cos(deg2rad($branchLat)) * sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round(($earthRadius * $c) / 1000, 2); // Convert meters to kilometers

    }


function canOrder($id)
{
   $openStatus = branchOpen($id);

   if($openStatus == __('Open')){
    return true;
   }

   return false;

}


/**
 * Convert money to points
 * @param int $id
 * @param int $points
 * @return int
 */

function customerPointToMoney($id, $points)
{
    $customer = Customer::find($id);

    if (!$customer || !$customer->card) {
        return 0;
    }

    $card = $customer->card;

    // Example: 500 points = 1$
    // money = points / point_to_money
    if ($card->point_to_money <= 0) {
        return 0;
    }

    return $points / $card->point_to_money;
}

/**
 * Convert money to points
 * @param int $id
 * @param float $money
 * @return float
 */
/**
 * Convert money to points based on customer's membership tier
 * @param int $id Customer ID
 * @param float $money Amount spent
 * @return int Calculated points
 */
function customerMoneyToPoint($id, $money)
{
    $customer = Customer::find($id);

    if (!$customer) {
        return 0;
    }

    $card = $customer->card;

    // Fallback to first card if customer has no card
    if (!$card) {
        $card = CustomerCard::orderBy('id', 'asc')->first();
    }

    $moneyToPointRatio = 0;

    if ($card && $card->money_to_point > 0) {
        $moneyToPointRatio = $card->money_to_point;
    } else {
        // Ultimate fallback to global settings
        $setting = \App\Models\General\Setting::first();
        $moneyToPointRatio = $setting->money_to_point ?? 1;
    }

    if ($moneyToPointRatio <= 0) {
        return 0;
    }

    return (int) round($money / $moneyToPointRatio);
}

/**
 * Get fixed points for specific actions potentially based on customer's membership tier
 * @param int $id Customer ID
 * @param string $actionType type of action (login, referral, register)
 * @return int points to award
 */
function customerActionPoints($id, $actionType)
{
    $setting = \App\Models\General\Setting::first();
    $points = 0;

    switch ($actionType) {
        case 'login':
            $points = $setting->daily_login_points ?? 0;
            break;
        case 'referral':
            $points = $setting->friend_invitation_points ?? 0;
            break;
        case 'register':
            $points = $setting->first_register_point ?? 0;
            break;
    }

    // Future enhancement: Multiply or override points based on $customer->card if needed
    // For now, we centralize the setting access here.

    return (int) $points;
}

/**
 * Calculate points based on customer and amount (Explicitly requested format)
 * @param \App\Models\Customer\Customer $customer
 * @param float $amount
 * @return int
 */
function calculatePoints(\App\Models\Customer\Customer $customer, float $amount)
{
    return customerMoneyToPoint($customer->id, $amount);
}

function productAvailableInBranch($branch_id, $product_id)
{
    $branchProduct = BranchProduct::where('branch_id', $branch_id)->where('product_id', $product_id)->first();

    if(!$branchProduct) { return false; }

    return $branchProduct->status ? true : false;
}

/**
 * Normalizes phone number by removing non-digits and specific prefixes (+966, 966, 0).
 * Results in a standard format: 5xxxxxxxx
 *
 * @param string|null $phone
 * @return string|null
 */
function normalizePhone($phone)
{
    if (empty($phone)) {
        return $phone;
    }

    // 1. Remove all non-numeric characters (spaces, dashes, etc.)
    $normalized = preg_replace('/[^0-9]/', '', $phone);

    // 2. Remove Saudi country code (966) if present at the start
    if (str_starts_with($normalized, '966')) {
        $normalized = substr($normalized, 3);
    }

    // 3. Remove leading zero
    $normalized = ltrim($normalized, '0');

    // 4. Return only if it starts with 5 (standard Saudi mobile format)
    // or return the cleaned string if it's potentially valid but different.
    return $normalized;
}
