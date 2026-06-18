<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @group Users
 * 
 * APIs untuk mengelola users
 */
class UserController extends Controller
{
    /**
     * Daftar semua users
     * 
     * Mengembalikan daftar semua users yang ada di database.
     * 
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "John Doe",
     *       "email": "john@example.com",
     *       "created_at": "2026-06-04T00:00:00.000000Z",
     *       "updated_at": "2026-06-04T00:00:00.000000Z"
     *     }
     *   ]
     * }
     */
    public function index(Request $request)
    {
        return response()->json([
            'data' => User::all()
        ]);
    }

    /**
     * Membuat user baru
     * 
     * Membuat user baru dengan data yang diberikan.
     * 
     * @bodyParam name string required Nama user. Example: "John Doe"
     * @bodyParam email string required Email user. Example: "john@example.com"
     * @bodyParam password string required Password user. Example: "password"
     * 
     * @response 201 {
     *   "data": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "john@example.com",
     *     "created_at": "2026-06-04T00:00:00.000000Z",
     *     "updated_at": "2026-06-04T00:00:00.000000Z"
     *   }
     * }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8'
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);

        return response()->json([
            'data' => $user
        ], 201);
    }


    /**
     * Tampilkan user tertentu
     * 
     * Menampilkan detail user berdasarkan ID.
     * 
     * @urlParam user integer required ID dari user. Example: 1
     * 
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "john@example.com",
     *     "created_at": "2026-06-04T00:00:00.000000Z",
     *     "updated_at": "2026-06-04T00:00:00.000000Z"
     *   }
     * }
     */
    public function show(Request $request, User $user)
    {
        return response()->json([
            'data' => $user
        ]);
    }

    /**
     * Update user
     * 
     * Mengupdate data user yang sudah ada.
     * 
     * @urlParam user integer required ID dari user. Example: 1
     * @bodyParam name string required Nama user. Example: "Jane Doe"
     * @bodyParam email string required Email user. Example: "jane@example.com"
     * 
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "name": "Jane Doe",
     *     "email": "jane@example.com",
     *     "created_at": "2026-06-04T00:00:00.000000Z",
     *     "updated_at": "2026-06-13T00:00:00.000000Z"
     *   }
     * }
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id
        ]);

        $user->update($validated);

        return response()->json([
            'data' => $user
        ]);
    }

    /**
     * Hapus user
     * 
     * Menghapus user dari database.
     * 
     * @urlParam user integer required ID dari user. Example: 1
     * 
     * @response 204
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
