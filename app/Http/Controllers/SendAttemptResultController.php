<?php

namespace App\Http\Controllers;

use App\Models\SendAttemptResult;
use App\Http\Requests\StoreSendAttemptResultRequest;
use App\Http\Requests\UpdateSendAttemptResultRequest;

class SendAttemptResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sendAttemptResults = SendAttemptResult::all();
        return $sendAttemptResults;
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
    public function store(StoreSendAttemptResultRequest $request)
    {
        $sendAttemptResult = SendAttemptResult::create([
            'date_of_sending_results' => $request->date_of_sending_results,
            'details' => $request->details,
            'error_code' => $request->error_code,
            'nombre_de_tentative' => $request->nombre_de_tentative,
        ]);

        return response($sendAttemptResult, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SendAttemptResult $sendAttemptResult)
    {
        return $sendAttemptResult;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SendAttemptResult $sendAttemptResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSendAttemptResultRequest $request, SendAttemptResult $sendAttemptResult)
    {
        $sendAttemptResult->update([
            'date_of_sending_results' => $request->date_of_sending_results,
            'details' => $request->details,
            'error_code' => $request->error_code,
            'nombre_de_tentative' => $request->nombre_de_tentative,
        ]);

        return $sendAttemptResult;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SendAttemptResult $sendAttemptResult)
    {
        $sendAttemptResult->delete();

        return null;
    }
}
