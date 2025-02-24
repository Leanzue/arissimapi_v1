<?php

namespace App\Http\Controllers;

use App\Models\Sim;
use Illuminate\Support\Str;
use App\Http\Requests\Sim\StoreSimRequest;
use App\Http\Requests\Sim\UpdateSimRequest;

class SimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sims = Sim::all();
        return view('sims.index', compact('sims'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sims.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSimRequest $request)
    {
        $sim = Sim::create([
            'uuid' => Str::uuid()->toString(),
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
        return view('sims.edit', compact('sim'));
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
    public function destroy(Sim $sims)
    {
        $sims->delete();
        return redirect()->route('sims.index')->with('success', ' Une Sim supprimée avec succès.');
    }
}
