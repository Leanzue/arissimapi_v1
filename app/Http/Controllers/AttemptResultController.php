<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\AttemptResult;
use App\Http\Requests\AttemptResult\StoreAttemptResultRequest;
use App\Http\Requests\AttemptResult\UpdateAttemptResultRequest;

class AttemptResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attemptresults = AttemptResult::all();
        return view('attemptresults.index', compact('attemptresults'));
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
    public function store(StoreAttemptResultRequest $request)
    {
        $treatementResult = AttemptResult::create([
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
    public function show(AttemptResult $treatementResult)
    {

        return $treatementResult;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttemptResult $treatementResult)
    {
        return view('treatementResults.edit', compact('treatementResult'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttemptResultRequest $request, AttemptResult $treatementResult)
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
    public function destroy(AttemptResult $treatementResult)
    {
        $treatementResult->delete();
        return response()->json(['success' => true, 'message' => 'Résultat de traitement supprimé avec succès.']);
    }

}
