<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreNoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{

    // 2. Controller untuk menampilkan semua data mockup yang ada
    public function index() {
        $notes = DB::table('notes')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data Berhasil diambil',
            'data' => $notes
        ]);
    }

   public function store(StoreNoteRequest $request){
        $validatedData = $request->validated();

        $id = DB::table('notes')->insertGetId([
            'title'      => $validatedData['title'],
            'isi'        => $validatedData['isi'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Catatan berhasil ditambahkan!',
            'data'    => ['id' => $id, 'title' => $validatedData['title']]
        ], 201); // 201 artinya 'Created'
    }

    // C. SELECT WHERE: Detail Satu Data
    public function show($id){
        $note = DB::table('notes')->where('id', $id)->first();

        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Catatan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $note
        ], 200);
    }

    // D. UPDATE: Mengubah Data
    public function update(Request $request, $id){
        $updated = DB::table('notes')
            ->where('id', $id)
            ->update([
                'title'      => $request->title,
                'isi'        => $request->isi,
                'updated_at' => now(),
            ]);

        if (!$updated) {
            return response()->json(['message' => 'Gagal update atau data tidak ditemukan'], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Catatan berhasil diperbarui!'
        ], 200);
    }

    // E. DELETE: Menghapus Data
    public function destroy($id){
        $deleted = DB::table('notes')->where('id', $id)->delete();

        if (!$deleted) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Catatan berhasil dihapus!'
        ], 200);
    }
}
