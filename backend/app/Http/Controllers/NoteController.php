<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Auth::user()->notes()->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNoteRequest $request)
    {
        $note = Auth::user()->notes()->create([
            'body' => $request->body,
        ]);
        return response('Note created successfully', response()::HTTP_CREATED)
            ->setContent(['data' => $note]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        abort_if(!$note->user()->is(Auth::user()), response()::HTTP_FORBIDDEN);
        return $note;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        abort_if(! $note->user()->is(Auth::user()), response()::HTTP_FORBIDDEN);
        $note->save();
        $note->refresh();
        return response('Note updated successfully', response()::HTTP_OK)
            ->setContent(['data' => $note]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        abort_if(!$note->user()->is(Auth::user()), response()::HTTP_FORBIDDEN);
        $note->delete();
        return response('Note deleted successfully', response()::HTTP_OK);
    }
}
