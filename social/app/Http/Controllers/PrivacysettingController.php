<?php

namespace App\Http\Controllers;

use App\Models\Privacysetting;
use Illuminate\Http\Request;

class PrivacysettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $privacySettings = PrivacySetting::all();

        return response()->json(['privacy' => $privacySettings], 201);

    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Privacysetting $privacysetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Privacysetting $privacysetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Privacysetting $privacysetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Privacysetting $privacysetting)
    {
        //
    }
}
