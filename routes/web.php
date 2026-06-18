<?php

use Illuminate\Support\Facades\Route;

// Route untuk download Dokumentasi Pertemuan 10
Route::get('/pertemuan-10/collection', function () {
    $path = storage_path('app/private/scribe/collection.json');
    
    if (!file_exists($path)) {
        return response()->json(['error' => 'Collection not found'], 404);
    }
    
    return response()->file($path, [
        'Content-Disposition' => 'attachment; filename="postman-collection.json"',
        'Content-Type' => 'application/json'
    ]);
});

// Route untuk download OpenAPI spec
Route::get('/pertemuan-10/openapi', function () {
    $path = storage_path('app/private/scribe/openapi.yaml');
    
    if (!file_exists($path)) {
        return response()->json(['error' => 'OpenAPI spec not found'], 404);
    }
    
    return response()->file($path, [
        'Content-Disposition' => 'attachment; filename="openapi.yaml"',
        'Content-Type' => 'application/x-yaml'
    ]);
});

// Route untuk download Dokumentasi via /postman/collection
Route::get('/postman/collection', function () {
    $path = storage_path('app/private/scribe/collection.json');
    
    if (!file_exists($path)) {
        return response()->json(['error' => 'Collection not found'], 404);
    }
    
    return response()->file($path, [
        'Content-Disposition' => 'attachment; filename="postman-collection.json"',
        'Content-Type' => 'application/json'
    ]);
});

// Route untuk download OpenAPI spec via /postman/openapi
Route::get('/postman/openapi', function () {
    $path = storage_path('app/private/scribe/openapi.yaml');
    
    if (!file_exists($path)) {
        return response()->json(['error' => 'OpenAPI spec not found'], 404);
    }
    
    return response()->file($path, [
        'Content-Disposition' => 'attachment; filename="openapi.yaml"',
        'Content-Type' => 'application/x-yaml'
    ]);
});

Route::get('/', function () {
    return view('welcome');
});

