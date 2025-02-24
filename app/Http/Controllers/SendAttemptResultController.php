<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\SendAttemptResult;
use Illuminate\Container\Container;
use App\Http\Requests\SendAttemptResult\StoreSendAttemptResultRequest;
use App\Http\Requests\SendAttemptResult\UpdateSendAttemptResultRequest;

class SendAttemptResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sendattemptresults = SendAttemptResult::all();
        return view('sendattemptresults.index', compact('sendattemptresults'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sendattemptresults.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreSendAttemptResultRequest $request
     * @return Container|mixed|object
     */
    public function store(StoreSendAttemptResultRequest $request)
    {
        dd($request->all());
        $sendAttemptResult = SendAttemptResult::create([
            'uuid' => Str::uuid()->toString(),
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
        return view('sendattemptresults.edit', compact('sendAttemptResult'));
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
    public function destroy(SendAttemptResult $sendattemptresults)
    {
        $sendattemptresults->delete();
        return redirect()->route('sendattemptresults.index')->with('success', 'Résultat de tentative d\'envoi supprimé avec succès.');
    }

}
