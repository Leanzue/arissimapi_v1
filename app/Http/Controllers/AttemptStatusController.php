<?php

namespace App\Http\Controllers;

use App\Models\AttemptStatus;
use App\Models\RequestStatus;
use App\Http\Requests\AttemptStatus\StoreAttemptStatusRequest;
use App\Http\Requests\AttemptStatus\UpdateAttemptStatusRequest;

class AttemptStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $AttemptStatuses = AttemptStatus::all();
        return $AttemptStatuses;
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
     * @param StoreAttemptStatusRequest $request
     * @param $attemptStatus
     * @return
     */
    public function store(StoreAttemptStatusRequest $request, $attemptStatus)
    {
        $AttemptStatus = AttemptStatus::create([
            'nombre_essais' => $request->nombre_essais,
            'error_code' => $request->error_code,
            'details' => $request->details,
            'statut' => $request->statut,
            'comment' => $request->comment,
        ]);
        return response()(attemptStatus, 201);
    }

    /**
     * Display the specified resource.
     * @param AttemptStatus $attemptStatus
     * @param $attemptStatuses
     * @return
     */
    public function show(AttemptStatus $attemptStatus, $attemptStatuses)
    {
        return $attemptStatuses;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttemptStatus $attemptStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateAttemptStatusRequest $request
     * @param AttemptStatus $attemptStatus
     * @param $attemptStatuses
     * @return
     */
    public function update(UpdateAttemptStatusRequest $request, AttemptStatus $attemptStatus, $attemptStatuses)
    {
        $attemptStatus->update([
            'nombre_essais' => $request->nombre_essais,
            'error_code' => $request->error_code,
            'details' => $request->details,
            'statut' => $request->statut,
            'comment' => $request->comment,
        ]);


        return $attemptStatuses;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttemptStatus $attemptStatus)
    {

        $attemptStatus->delete();

        return null;
    }
}
