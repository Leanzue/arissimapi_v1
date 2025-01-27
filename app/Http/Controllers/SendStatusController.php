<?php

namespace App\Http\Controllers;

use App\Models\SendStatus;
use App\Models\SendResult;
use App\Http\Requests\StoreSendStatusRequest;
use App\Http\Requests\UpdateSendStatusRequest;

class SendStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sendStatuses = SendStatus::all();
        return $sendStatuses;
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
    public function store(StoreSendStatusRequest $request)
    {

        $sendStatus = SendStatus::create([
            'priority' => $request->priority,
            'libellé' => $request->libellé,
        ]);

        return response($sendStatus, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SendStatus $sendStatus)
    {
        return $sendStatus;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SendStatus $sendStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSendStatusRequest $request, SendStatus $sendStatus)
    {
        $sendStatus->update([
            'priority' => $request->priority,
            'libellé' => $request->libellé,
        ]);

        return $sendStatus;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SendStatus $sendStatus)
    {
        $sendStatus->delete();

        return null;
    }
}
