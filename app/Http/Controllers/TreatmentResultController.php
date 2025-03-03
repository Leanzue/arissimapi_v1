<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\TreatmentAttempt\TreatmentResult;
use App\Http\Requests\TreatmentResult\StoreTreatmentResultRequest;
use App\Http\Requests\TreatmentResult\UpdateTreatmentResultRequest;

class TreatmentResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $treatmentresults = TreatmentResult::all();
        return view('treatmentresults.index', compact('treatmentresults'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('treatementResults.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTreatmentResultRequest $request)
    {
        $treatementResult = TreatmentResult::create([
            'uuid' => Str::uuid()->toString(),
            'date_tentative' => $request->date_tentative ?? now(),
            'details' => $request->details,
            'resultat' => $request->resultat,
            'comment' => $request->comment,
        ]);

        return response($treatementResult, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TreatmentResult $treatementResult)
    {

        return $treatementResult;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TreatmentResult $treatementResult)
    {
        return view('treatementResults.edit', compact('treatementResults'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTreatmentResultRequest $request, TreatmentResult $treatementResult)
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
    public function destroy(TreatmentResult $treatementResult)
    {
        $treatementResult->delete();
        return response()->json(['success' => true, 'message' => 'Résultat de traitement supprimé avec succès.']);
    }

}
