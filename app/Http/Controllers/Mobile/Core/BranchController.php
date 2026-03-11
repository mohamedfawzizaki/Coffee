<?php

namespace App\Http\Controllers\Mobile\Core;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\Core\Branch\BranchByLocationResource;
use App\Http\Resources\Mobile\Core\Branch\BranchResource;
use App\Http\Resources\Mobile\Core\Branch\SingleBranchResource;
use App\Models\Branch\Branch;
use App\Models\General\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all   = Branch::active()->get();

        $faved = Auth::user()->faved_branches;

        return response()->json([
            'all'   => BranchResource::collection($all),
            'faved' => BranchResource::collection($faved)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $branch = Branch::find($id);

        if (!$branch) {   return $this->notFound(); }

        if(!$branch->status){
            return $this->error(__('Branch is not active'));
        }

        return new SingleBranchResource($branch);
    }


    /**
     * Get branches by location
     */
    public function branchesByLocation(Request $request)
    {
       $request->validate([
        'lat' => 'required|numeric',
        'lng' => 'required|numeric',
       ]);

       $settings = Setting::first();

       $distance = $settings->distance;

       $branches = Branch::active()->get();

       $branches = $branches->map(function($branch) use ($request, $distance){

        $currentDistance = calculateDistance($request->lat, $request->lng, $branch->lat, $branch->lng);

        if($currentDistance <= $distance){

            $branch->available = true;

            $branch->distance = $currentDistance;

        }else{

            $branch->available = false;

            $branch->distance = $currentDistance;
        }

        return $branch;

       });

       return BranchByLocationResource::collection($branches);

    }

}
