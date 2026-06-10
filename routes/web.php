<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware(['check.role:admin'])->group(function(){
//     Route::resource('notes', NoteController::class);
// });
