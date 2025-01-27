<?php

namespace App\Http\Controllers;

use App\Models\TreatementAttempt;
use App\Http\Requests\StoreTreatementAttemptRequest;
use App\Http\Requests\UpdateTreatementAttemptRequest;

class TreatementAttemptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $treatementAttempts = TreatementAttempt::all();
        return $treatementAttempts;
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
    public function store(StoreTreatementAttemptRequest $request)
    {
        $treatementAttempt = TreatementAttempt::create([
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'resultat' => $request->resultat,
            'description' => $request->description,
        ]);

        return response($treatementAttempt, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TreatementAttempt $treatementAttempt)
    {
        return $treatementAttempt;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TreatementAttempt $treatementAttempt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTreatementAttemptRequest $request, TreatementAttempt $treatementAttempt)
    {
        $treatementAttempt->update([
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'resultat' => $request->resultat,
            'description' => $request->description,
        ]);

        return $treatementAttempt;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TreatementAttempt $treatementAttempt)
    {
        $treatementAttempt->delete();

        return null;
    }
}
