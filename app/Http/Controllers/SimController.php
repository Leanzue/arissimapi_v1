<?php

namespace App\Http\Controllers;

use App\Models\Sim;
use App\Http\Requests\StoreSimRequest;
use App\Http\Requests\UpdateSimRequest;

class SimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sims = Sim::all();
        return $sims;
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
    public function store(StoreSimRequest $request)
    {
        $sim = Sim::create([
            'iccid' => $request->iccid,
            'imsi' => $request->imsi,
            'puk' => $request->puk,
            'pin' => $request->pin,
        ]);

        return response($sim, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sim $sim)
    {
        return $sim;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sim $sim)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSimRequest $request, Sim $sim)
    {

        $sim->update([
            'iccid' => $request->iccid,
            'imsi' => $request->imsi,
            'puk' => $request->puk,
            'pin' => $request->pin,
        ]);

        return $sim;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sim $sim)
    {
        $sim->delete();

        return null;
    }
}
