<?php

namespace App\Http\Controllers;

use App\Models\TreatementResult;
use App\Http\Requests\StoreTreatementResultRequest;
use App\Http\Requests\UpdateTreatementResultRequest;

class TreatementResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $treatementResults = TreatementResult::all();
        return $treatementResults;
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
    public function store(StoreTreatementResultRequest $request)
    {
        $treatementResult = TreatementResult::create([
            'date_tentative' => $request->date_tentative,
            'details' => $request->details,
            'resultat' => $request->resultat,
            'comment' => $request->comment,
        ]);

        return response($treatementResult, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TreatementResult $treatementResult)
    {
        return $treatementResult;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TreatementResult $treatementResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTreatementResultRequest $request, TreatementResult $treatementResult)
    {
        $treatementResult->update([
            'date_tentative' => $request->date_tentative,
            'details' => $request->details,
            'resultat' => $request->resultat,
            'comment' => $request->comment,
        ]);

        return $treatementResult;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TreatementResult $treatementResult)
    {
        $treatementResult->delete();

        return null;
    }
}
