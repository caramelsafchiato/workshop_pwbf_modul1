<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    // Buka halaman tambah
    public function create()
    {
        $vendors = \App\Models\Vendor::all();
        return view('admin.user.create', compact('vendors'));
    }

    // Simpan user baru
    public function store(Request $request)
    {
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'idvendor' => $request->role == 'vendor' ? $request->idvendor : null,
        ]);
        return redirect()->route('user.index')->with('success', 'User berhasil ditambah!');
    }

    // Buka halaman edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $vendors = \App\Models\Vendor::all();
        return view('admin.user.edit', compact('user', 'vendors'));
    }

    // Update data user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'idvendor' => $request->role == 'vendor' ? $request->idvendor : null,
        ];
        
        if($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);
        return redirect()->route('user.index')->with('success', 'User berhasil diupdate!');
    }
}