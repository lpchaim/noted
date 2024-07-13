<?php

use App\Http\Controllers\NoteController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/token/create', function (Request $request) {
    $request->validate([
        'email' => ['required' | 'email'],
        'password' => 'required',
        'token_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken($request->token_name, [
        User::abilities()::NotesCreate,
        User::abilities()::NotesRead,
        User::abilities()::NotesUpdate,
        User::abilities()::NotesRemove,
    ]);

    return $token->plainTextToken;
});

Route::prefix('/notes')
    ->controller(NoteController::class)
    ->middleware([
        'auth:sanctum',
        'cache.headers:private;max_age=2628000;etag',
    ])
    ->group(fn() => [
        Route::get('/', 'index')->middleware(['ability:' . User::abilities()::NotesRead->value]),
        Route::get('/{id}', 'show')->middleware(['ability:' . User::abilities()::NotesRead->value]),
        Route::post('/{id}', 'store')->middleware(['ability:' . User::abilities()::NotesCreate->value]),
        Route::patch('/{id}', 'update')->middleware(['ability:' . User::abilities()::NotesUpdate->value]),
        Route::delete('/{id}', 'destroy')->middleware(['ability:' . User::abilities()::NotesRemove->value]),
    ]);
