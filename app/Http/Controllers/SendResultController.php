<?php

namespace App\Http\Controllers;

use App\Models\SendResult;
use App\Http\Requests\StoreSendResultRequest;
use App\Http\Requests\UpdateSendResultRequest;

class SendResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sendResults = SendResult::all();
        return $sendResults;
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
    public function store(StoreSendResultRequest $request)
    {
        $sendResult = SendResult::create([
            'result_description' => $request->result_description,
            'nombre_tentative' => $request->nombre_tentative,
            'date_envoi' => $request->date_envoi,
            'error_code' => $request->error_code,
        ]);

        return response()(sendResult, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SendResult $sendResult)
    {
        return $sendResult;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SendResult $sendResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSendResultRequest $request, SendResult $sendResult)
    {
        $sendResult->update([
            'result_description' => $request->result_description,
            'nombre_tentative' => $request->nombre_tentative,
            'date_envoi' => $request->date_envoi,
            'error_code' => $request->error_code,
        ]);
        return $sendResult;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SendResult $sendResult)
    {
        $sendResult->delete();

        return null;
    }
}
