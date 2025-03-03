<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\TreatmentAttempt\TreatmentAttempt;
use App\Http\Requests\TreatmentAttempt\StoreTreatmentAttemptRequest;
use App\Http\Requests\TreatmentAttempt\UpdateTreatmentAttemptRequest;

class TreatmentAttemptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $treatmentattempts = TreatmentAttempt::all();
        return view('treatmentattempts.index', compact('treatmentattempts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('treatmentattempts.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreTreatmentAttemptRequest $request
     * @return \Illuminate\Container\Container|mixed|object
     */
    public function store(StoreTreatmentAttemptRequest $request)
    {
        $treatmentAttempt = TreatmentAttempt::create([
            'uuid' => Str::uuid()->toString(),
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'description' => $request->description,
        ]);

        return response($treatmentAttempt, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TreatmentAttempt $treatmentAttempt)
    {
        return $treatmentAttempt;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TreatmentAttempt $treatmentAttempt)
    {
        return view('treatmentattempts.edit', compact('treatmentAttempt'));
    }


    /**
     * Update the specified resource in storage.
     * @param UpdateTreatmentAttemptRequest $request
     * @param TreatmentAttempt $treatmentAttempt
     * @param $treatmentAttempt
     * @return
     */
    public function update(UpdateTreatmentAttemptRequest $request, TreatmentAttempt  $treatmentAttempt)
    {
        $treatmentAttempt->update([
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'date_fin' => $request->date_fin,
            'description' => $request->description,
        ]);

        return response()->json($treatmentAttempt);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TreatmentAttempt $treatmentattempts)
    {
        $treatmentattempts->delete();
        return redirect()->route('treatmentattempts.index')->with('success', 'un resultat de traitement supprimé avec succès.');
    }
}
