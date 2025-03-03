<?php

namespace App\Http\Controllers;


use App\Models\TreatmentAttempt\Treatment;
use App\Http\Requests\TreatmentStatus\StoreTreatmentStatusRequest;
use App\Http\Requests\TreatmentStatus\UpdateTreatmentStatusRequest;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $treatments = Treatment::all();
        return view('treatments.index', compact('treatments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Treatments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTreatmentStatusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Treatment $treatment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Treatment $treatment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTreatmentStatusRequest $request, Treatment $treatment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Treatment $treatment)
    {
        //
    }
}
