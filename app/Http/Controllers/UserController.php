<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function __construct(User $user)     
    {
        $this->user = $user;
    }
    public function index()
    {
        $users = $this->user->get();
        return view('user_admin.index', compact('users'));
    }

    public function create()
    {
        return view('user_admin.create');
    }

    public function store(Request $request )
    {
        $validate = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,{$id},id,deleted_at,NULL',
            'posisi' => 'required',
            'email' => 'required|unique:users,email,{$id},id,deleted_at,NULL',
            'telepon' => 'required',
            'alamat' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);
        
        $insert = User::insert([
            'name' => $request->name,
            'username' => $request->username,
            'posisi' => $request->posisi,
            'email'   => $request->email,
            'telepon'   => $request->telepon,
            'alamat'   => $request->alamat,
            'password' => bcrypt($request->password)
        ]);

        if($insert == true ){
            return redirect()->route('user')->with(['message' => 'Berhasil Menambah Pengguna', 'type' => 'success']);
        } else {
            return redirect()->route('user')->with(['message' => 'Gagal Menambah Pengguna', 'type' => 'danger']);
        }
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        return view('user_admin.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        
        $validate = $request->validate([
            'name' => 'required',
            'username' => 'unique:users,username,{$id},id,deleted_at,NULL', 
            'posisi' => 'required',
            'email' => 'unique:users,email,{$id},id,deleted_at,NULL',
            'alamat' => 'required',
            'telepon' => 'required'
        ]);

        $user = User::where('id', $id);

        $update = $user->update([
            'name' => $request->name,
            'username' => $request->username ?? $user->first()->username,
            'posisi' => $request->posisi,
            'email' => $request->email ?? $user->first()->email,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon
        ]);

        if($update == true) {
            return redirect()->route('user')->with(['message' => 'Berhasil Mengubah Data Pengguna', 'type' => 'success']);
        } else {
            return redirect()->route('user')->with(['message' => 'Gagal Mengubah Data Pengguna', 'type' => 'danger']);
        }
    }

    public function destroy($id)
    {
        if(User::destroy($id)) {
            return redirect()->route('user')->with(['message' => 'Berhasil Menghapus Pengguna', 'type' => 'success']);
        } else {
            return redirect()->route('user')->with(['message' => 'Gagal Menghapus Pengguna, Silahkan coba lagi', 'type' => 'danger']);
        }
    }
}
