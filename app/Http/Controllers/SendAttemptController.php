<?php

namespace App\Http\Controllers;

use App\Models\SendAttempt;
use App\Http\Requests\StoreSendAttemptRequest;
use App\Http\Requests\UpdateSendAttemptRequest;

class SendAttemptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $sendAttempts = SendAttempt::all();
        return $sendAttempts;
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
    public function store(StoreSendAttemptRequest $request)
    {
        $sendAttempt = SendAttempt::create([
        'response_data' => $request->response_data,
        'response_time' => $request->response_time,
    ]);

        return response()($sendAttempt, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SendAttempt $sendAttempt)
    {
        return $sendAttempt;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SendAttempt $sendAttempt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSendAttemptRequest $request, SendAttempt $sendAttempt)
    {
        $sendAttempt->update([
            'response_data' => $request->response_data,
            'response_time' => $request->response_time,
        ]);

        return $sendAttempt;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SendAttempt $sendAttempt)
    {
        $sendAttempt->delete();

        return null;
    }
}
