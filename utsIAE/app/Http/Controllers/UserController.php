<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json(
            [ 'massage' => 'Data berhasil ditemukan',
            'data' => $users
        ], 200);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // $validated['password'] = bcrypt($validated['password']);

        $users = User::create($validated);
        
        return response()->json($users, 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $users = User::find($id);
        if (!$users) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        $users->name = $validated['name'];
        $users->email = $validated['email'];
        $users->password = $validated['password'];
        $users->save();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => $users
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $users = User::find($id);
        if (!$users) {
        return response()->json(['message' => 'Data tidak ditemukan']);
        }
    
        // Hapus komik
        $users->delete();
    
        return response()->json(['message' => 'Data berhasil dihapus'], 200);
        }
    }

