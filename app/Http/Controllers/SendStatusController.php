<?php

namespace App\Http\Controllers;

use App\Models\SendStatus;
use Illuminate\Support\Str;
use App\Http\Requests\SendStatus\StoreSendStatusRequest;
use App\Http\Requests\SendStatus\UpdateSendStatusRequest;

class SendStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sendstatuses = SendStatus::all();
        return view('sendstatuses.index', compact('sendstatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sendStatuses.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreSendStatusRequest $request
     * @return
     */
    public function store(StoreSendStatusRequest $request)
    {
        $sendstatus = SendStatus::create([
            'uuid' => Str::uuid()->toString(),
            'priority' => $request->priority,
            'libellé' => $request->libellé,
        ]);
        return response()->json( $sendstatus, 201);
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
        return view('sendStatuses.edit', compact('sendStatus'));
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
    public function destroy($id)
    {
        $sendStatus = SendStatus::find($id);
        if ($sendStatus) {
            $sendStatus->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => 'Élément non trouvé'], 404);
        }
    }


}
