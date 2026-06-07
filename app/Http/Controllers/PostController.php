<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Post;


class PostController extends Controller
{
    // 1. function untuk menampilkan semua data pada tabel post
    public function index(){
        // mengambil semua data dari table post menggunakan metode all
        $posts = Post::with('user')->paginate(50);


        return view('posts.index', compact('posts'));
    }




    // 2. function untuk menampilkan form tambah data
    public function create(){
        return view('posts.create');
    }


    // 3. funtction untuk menambah data pada sistem
    public function store(Request $request){
        $validateData = $request->validate([
            'title'=>'required|max:255',
            'content'=>'required'
        ]);
        $validateData['user_id']=1;


        Post::create($validateData);
     return redirect('/posts')->with('success', 'Data berhasil di input');
    }

    // 4. function untuk menampilkan form edit data
    public function edit(){

    }

    // 5. function untuk menjalankan sistem edit data
    public function update(){

    }

    // 6. function untuk menghapus data pada sistem
    public function destroy(){

    }

}
