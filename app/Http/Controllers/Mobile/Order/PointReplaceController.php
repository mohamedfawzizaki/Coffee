<?php

namespace App\Http\Controllers\Mobile\Order;

use App\Http\Controllers\Controller;
use App\Service\Mobile\Order\PointReplaceService;
use Illuminate\Http\Request;

class PointReplaceController extends Controller
{

    public function __construct(private PointReplaceService $pointReplaceService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->pointReplaceService->storePointReplace($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
