<?php

namespace App\Http\Controllers;

use App\Models\SimRequest;
use App\Http\Requests\StoreSimRequestRequest;
use App\Http\Requests\UpdateSimRequestRequest;

class SimRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $simRequests = SimRequest::all();
        return $simRequests;
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
    public function store(StoreSimRequestRequest $request)
    {
        $simRequest = SimRequest::create([
            'description' => $request->description,
            'adresse' => $request->adresse,
            'date' => $request->date,
            'code' => $request->code,
        ]);

        return response($simRequest, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SimRequest $simRequest)
    {
       return $simRequest;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SimRequest $simRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSimRequestRequest $request, SimRequest $simRequest)
    {
        $simRequest->update([
            'description' => $request->description,
            'adresse' => $request->adresse,
            'date' => $request->date,
            'code' => $request->code,
        ]);

        return $simRequest;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SimRequest $simRequest)
    {
        $simRequest->delete();

        return null;
    }
}
