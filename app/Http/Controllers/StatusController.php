<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = Status::all();
        return $statuses;
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
    public function store(StoreStatusRequest $request)
    {

        $status = Status::create([
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusRequest $request, Status $status)
    {
        $status->update([
            'name' => $request->name,
            'code' => $request->code,
            'style' => $request->style,
            'is_default' => $request->is_default,
            'description' => $request->description,
        ]);

        return $status;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        $status->delete();

        return null;
    }
}
