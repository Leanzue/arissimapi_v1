<?php

namespace App\Http\Controllers;

use App\Models\SimRequest\SimRequestResponseFile;
use App\Http\Requests\SimRequestResponseFile\StoreSimRequestResponseFileRequest;
use App\Http\Requests\SimRequestResponseFile\UpdateSimRequestResponseFileRequest;

class SimRequestResponseFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $simRequestResponseFiles = SimRequestResponseFile::all();
        return view('simRequestResponseFiles.index', compact('simRequestResponseFiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('simRequestResponseFiles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSimRequestResponseFileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SimRequestResponseFile $simRequestResponse)
    {
        return $simRequestResponse;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SimRequestResponseFile $simRequestResponseFiles)
    {
        return view('simRequestResponseFiles.edit', compact('simRequestResponseFiles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSimRequestResponseFileRequest $request, SimRequestResponseFile $simRequestResponse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SimRequestResponseFile $simRequestResponseFiles)
    {
        $simRequestResponseFiles->delete();
        return redirect()->route('simRequestResponseFiles.index')->with('success', ' une requete supprimée avec succès.');
    }
}
