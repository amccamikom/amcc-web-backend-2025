<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreNoteRequest;
use Illuminate\Http\Request;
class NoteController extends Controller
{
    // 1. Data mockup array
    private $notes = [
    ['id'=>1, 'title'=>'Belajar laravel', 'isi'=>'target hari ini adalah belajar laravel controller'],
    ['id'=>2, 'title'=>'Belajar Github', 'isi'=>'target hari ini bisa cloning dari repo AMCC']
    ];

    // 2. Controller untuk menampilkan semua data mockup yang ada
    public function index() {
    return $this -> notes;
    }

    // 3. Controller untuk menampikan form post nya
    public function create(){
        return view('note-form');
    }

    // 4. Controller untuk menproses data dari input user
    public function store(StoreNoteRequest $request){
        $validatedData = $request->validated();

            return back()->with('/notes/create')->with('success', 'Catatan berhasil ditambahkan');
    }

    // 5. Controller untuk menampilkan page sesuai id yang kita ketik
    public function show($id){
        return "menampilkan page dengan id yang diketik " .$id;
    }

    // 6. Controller untuk menampilkan page edit
    public function edit($id){
        return view('note-edit', ['id'=>$id]);
    }

    // 7. Controller untuk menangkap proses update datanya
    public function update(Request $request, $id){
        return "proses update untuk catatan dengan id" .$id. "berhasil";
    }

    // 8. Controller untuk menghapus data yang ada
    public function destroy($id){
        return "catatan dengan id " .$id. " berhasil dihapus";
    }
}
