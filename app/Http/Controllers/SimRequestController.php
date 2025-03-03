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
     * @param StoreSimRequestRequest $request
     * @return \Illuminate\Container\Container|\Illuminate\Container\TClass|object
     */
    public function store(StoreSimRequestRequest $request)
    {
        $simRequest = SimRequest::registerNewRequest($request);

        return response($simRequest, 201);
    }

    /**
     * Display the specified resource.
     * @param SimRequest $simRequest
     * @return SimRequest
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
     * @param UpdateSimRequestRequest $request
     * @param SimRequest $simRequest
     * @return SimRequest
     */
    public function update(UpdateSimRequestRequest $request, SimRequest $simRequest)
    {
        $simRequest->update([
            'description' => $request->description,
            'adresse_ip' => $request->client_ip_address,
        ]);

        return $simRequest;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SimRequest $simrequests
     * @return mixed
     */
    public function destroy(SimRequest $simrequests)
    {
        $simrequests->delete();
        return redirect()->route('simrequests.index')->with('success', ' une requete supprimée avec succès.');
    }
}
