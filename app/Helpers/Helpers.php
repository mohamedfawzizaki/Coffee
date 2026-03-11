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
      $roles =  config('laratrust_seeder.roles_structure.superadmin');

        $roleModel = [];

        foreach ($roles as $key => $value) {

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

    $today = strtolower(Carbon::now()->format('l'));

    $now   = Carbon::now();

    $worktime = Worktime::whereRaw('LOWER(day) = ?', [$today])
        ->where('branch_id', $id)
        ->first();

    if (!$worktime) {
        return __('Closed');
    }

    $all_day = $worktime->all_day;

    if ($all_day) {
        return __('Open');
    }

    $fromTime = Carbon::parse($worktime->from);
    $toTime = Carbon::parse($worktime->to);

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
function customerMoneyToPoint($id, $money)
{
    $customer = Customer::find($id);

    if (!$customer || !$customer->card) {
        return 0;
    }

    $card = $customer->card;

    // Example: 100$ = 1 point
    // points = money / money_to_point
    if ($card->money_to_point <= 0) {
        return 0;
    }
    return round($money / $card->money_to_point);
}

function productAvailableInBranch($branch_id, $product_id)
{
    $branchProduct = BranchProduct::where('branch_id', $branch_id)->where('product_id', $product_id)->first();

    if(!$branchProduct) { return false; }

    return $branchProduct->status ? true : false;
}
