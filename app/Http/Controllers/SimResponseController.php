<?php

namespace App\Http\Controllers;

use App\Models\SimResponse;
use App\Http\Requests\SimResponse\StoreSimResponseRequest;
use App\Http\Requests\SimResponse\UpdateSimResponseRequest;

class SimResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $simresponse = SimResponse::all();
        return view('simresponses.index', compact('simresponse'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('simresponses.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreSimResponseRequest $request
     */
    public function store(StoreSimResponseRequest $request)
    {
        SimResponse::create([
            'iccid' => $request->iccid,
            'status' => $request->status,
            'status_change_date' => $request->status_change_date,
            'client_key_request' => $request->client_key_request,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SimResponse $simResponse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SimResponse $simResponse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSimResponseRequest $request, SimResponse $simResponse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SimResponse $simResponses)
    {
        $simResponses->delete();
        return redirect()->route('simResponses.index')->with('success', ' une requete supprimée avec succès.');
    }
}
