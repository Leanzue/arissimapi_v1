<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SendAttempt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\SendAttempt\StoreSendAttemptRequest;
use App\Http\Requests\SendAttempt\UpdateSendAttemptRequest;

class SendAttemptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sendattempts = SendAttempt::all();

        return view('sendattempts.index', compact('sendattempts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sendattempts.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreSendAttemptRequest $request
     * @param $sendAttempt
     * @return
     */
    protected function store(storeSendAttemptRequest $request)
    {   dd($request->all());
        $sendAttempt = SendAttempt::create([
            'uuid' => Str::uuid()->toString(),
            'response_data' => $request->response_data,
            'response_time' => $request->response_time ?? now(),
        ]);


        return response()->json($sendAttempt, 201);


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
        return view('sendattempts.edit', compact('sendAttempt'));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateSendAttemptRequest $request
     * @param SendAttempt $sendAttempt
     * @return
     */
    public function update(UpdateSendAttemptRequest $request, SendAttempt $sendAttempt,  $sendattempt)
    {
        $sendAttempt->update([
            'response_data' => $request->input('response_data'),
            'response_time' => $request->input('response_time'),
        ]);

        return response()->json($sendAttempt);;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SendAttempt $sendattempts)
    {

        $sendattempts->delete();
        return redirect()->route('sendattempts.index')->with('success', 'Résultat de tentative d\'envoi supprimé avec succès.');
    }

    /**
     * Additional methods and functionalities can be added here
     */
}
