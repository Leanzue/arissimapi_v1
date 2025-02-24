<?php

namespace App\Http\Controllers;

use App\Models\SendResult;
use Illuminate\Support\Str;
use App\Http\Requests\SendResult\StoreSendResultRequest;
use App\Http\Requests\SendResult\UpdateSendResultRequest;

class SendResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sendresults = SendResult::all();
        return view('sendresults.index', compact('sendresults'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sendResults.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSendResultRequest $request)
    {
        $sendResult = SendResult::create([
            'uuid' => Str::uuid()->toString(),
            'result_description' => $request->result_description,
            'nombre_tentative' => $request->nombre_tentative,
            'date_envoi' => $request->date_envoi ?? now(),
            'error_code' => $request->error_code,
        ]);

        return response()->json($sendResult, 201);
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
        return view('sendResults.edit', compact('sendResult'));
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
        return response()->json(['success' => true, 'message' => 'Résultat de tentative d\'envoi supprimé avec succès.']);
    }

}
