<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Support\Str;
use App\Http\Requests\status\StoreStatusRequest;
use App\Http\Requests\status\UpdateStatusRequest;


class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = Status::all();
        return view('statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusRequest $request)
    {

        $status = Status::create([
            'uuid' => Str::uuid()->toString(),
            'name' => $request->name,
            'code' => $request->code,
            'style' => $request->style,
            'is_default' => $request->is_default,
            'description' => $request->description,
        ]);

        return response($status, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        return $status;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        return view('statuses.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateStatusRequest $request, $id)
    {
        $status = Status::findOrFail($id);

        $validatedData = $request->validate($status->updateRules($id));

        $status->update($validatedData);

        return redirect()->route('statuses.index')->with('success', 'Statut mis à jour avec succès');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $statuses)
    {
        $statuses->delete();
        return redirect()->route('statuses.index')->with('success', 'un statut supprimé avec succès.');
    }
}
