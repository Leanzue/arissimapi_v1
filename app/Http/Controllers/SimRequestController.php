<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\SimRequest\SimRequest;
use App\Http\Requests\SimRequest\StoreSimRequestRequest;
use App\Http\Requests\SimRequest\UpdateSimRequestRequest;

class SimRequestController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $simrequests = SimRequest::all();
        return view('simrequests.index', compact('simrequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('simRequests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSimRequestRequest $request)
    {
        $simRequest = SimRequest::create([
            'uuid' => Str::uuid()->toString(),
            'description' => $request->description,
            'adresse_ip' => $request->adresse_ip,
            'date'=>$request->date,
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
        return view('simRequests.edit', compact('simRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSimRequestRequest $request, SimRequest $simRequest)
    {
        $simRequest->update([
            'description' => $request->description,
            'adresse_ip' => $request->adresse_ip,
            'date' => $request->date,
            'code' => $request->code,
        ]);

        return $simRequest;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SimRequest $simrequests)
    {
        $simrequests->delete();
        return redirect()->route('simrequests.index')->with('success', ' une requete supprimée avec succès.');
    }
}
