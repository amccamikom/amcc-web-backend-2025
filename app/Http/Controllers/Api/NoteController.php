<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

/**
 * @group Notes
 * 
 * APIs untuk mengelola notes
 */
class NoteController extends Controller
{
    /**
     * Daftar semua notes
     * 
     * Mengembalikan daftar semua notes yang ada di database.
     * 
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "title": "Judul Note",
     *       "content": "Isi content note",
     *       "user_id": 1,
     *       "created_at": "2026-06-06T00:00:00.000000Z",
     *       "updated_at": "2026-06-06T00:00:00.000000Z"
     *     }
     *   ]
     * }
     */
    public function index()
    {
        return response()->json([
            'data' => Note::all()
        ]);
    }

    /**
     * Membuat note baru
     * 
     * Membuat note baru dengan data yang diberikan.
     * 
     * @bodyParam title string required Judul note. Example: "Judul Note Pertama"
     * @bodyParam content string required Isi content. Example: "Ini adalah content note pertama"
     * 
     * @response 201 {
     *   "data": {
     *     "id": 1,
     *     "title": "Judul Note Pertama",
     *     "content": "Ini adalah content note pertama",
     *     "user_id": 1,
     *     "created_at": "2026-06-06T00:00:00.000000Z",
     *     "updated_at": "2026-06-06T00:00:00.000000Z"
     *   }
     * }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note = $request->user()->notes()->create($validated);

        return response()->json([
            'data' => $note
        ], 201);
    }

    /**
     * Tampilkan note tertentu
     * 
     * Menampilkan detail note berdasarkan ID.
     * 
     * @urlParam note integer required ID dari note. Example: 1
     * 
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "title": "Judul Note",
     *     "content": "Isi content note",
     *     "user_id": 1,
     *     "created_at": "2026-06-06T00:00:00.000000Z",
     *     "updated_at": "2026-06-06T00:00:00.000000Z"
     *   }
     * }
     * @response 404 {
     *   "message": "Note tidak ditemukan"
     * }
     */
    public function show(Note $note)
    {
        return response()->json([
            'data' => $note
        ]);
    }

    /**
     * Update note
     * 
     * Mengupdate data note yang sudah ada.
     * 
     * @urlParam note integer required ID dari note. Example: 1
     * @bodyParam title string required Judul note. Example: "Judul Note Update"
     * @bodyParam content string required Isi content. Example: "Ini adalah content note yang sudah diupdate"
     * 
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "title": "Judul Note Update",
     *     "content": "Ini adalah content note yang sudah diupdate",
     *     "user_id": 1,
     *     "created_at": "2026-06-06T00:00:00.000000Z",
     *     "updated_at": "2026-06-13T00:00:00.000000Z"
     *   }
     * }
     * @response 403 {
     *   "message": "Forbidden. You do not own this note."
     * }
     */
    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden. You do not own this note.'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note->update($validated);

        return response()->json([
            'data' => $note
        ]);
    }

    /**
     * Hapus note
     * 
     * Menghapus note dari database.
     * 
     * @urlParam note integer required ID dari note. Example: 1
     * 
     * @response 204
     * @response 403 {
     *   "message": "Forbidden. You do not own this note."
     * }
     * @response 404 {
     *   "message": "Note tidak ditemukan"
     * }
     */
    public function destroy(Request $request, Note $note)
    {
        if ($note->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden. You do not own this note.'], 403);
        }

        $note->delete();

        return response()->noContent();
    }
}
