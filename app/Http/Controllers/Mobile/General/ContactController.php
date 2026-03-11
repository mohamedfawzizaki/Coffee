<?php

namespace App\Http\Controllers\Mobile\General;

use App\Http\Controllers\Controller;
use App\Models\General\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'contacts' => Contact::where('customer_id', Auth::guard('mobile')->user()->id)->latest()->get()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required',
            'message'   => 'required|min:10',
        ]);

        Contact::create([
            'title'       => $request->title,
            'message'     => $request->message,
            'customer_id' => Auth::guard('mobile')->user()->id,
        ]);

        return $this->success(__('Contact created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
