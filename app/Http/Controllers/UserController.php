<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Log;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::where('id', '>', 2)->get();
        $users = User::where('role_id', '>', 1)->get();
        if( request()->id ) $users = User::where('id', request()->id)->get();
        
        return view('pages.management.user.index', [
            'page' => 'Pengaturan',
            'description' => 'Data User KSU Abdi Karya',
            'roles' => $roles,
            'users' => $users,
            'state' => ['Tidak Aktif', 'Aktif'],
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|unique:users',
            'role_id' => 'required',
        ]);

        try {
            $password = $request->username;
            $validatedData['password'] = \bcrypt( $password );
            
            $user = User::create($validatedData);
            $status = 'success';
            $message = 'Berhasil Menambahkan Data';

            Log::create([
                'model' => 'users',
                'data_id' => $user->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Pengguna ' . $user->name . ' Berhasil Dibuat!',
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $exception) {
            dd($exception);
            $status = 'error';
            $message = 'Gagal Menambahkan Data';
        }
        return redirect('/manajemen/pengguna')->with($status, $message);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'role_id' => 'required',
            'state' => 'required',
        ]);
        try {
            $user = User::where('id', $id)->first();
            if($request->password) {
                $validatedData['password'] = \bcrypt($request->password);
            }
            User::where('id', $user->id)->update($validatedData);
            $status = 'success';
            $message = 'Berhasil Mengubah Data';
            
            Log::create([
                'model' => 'users',
                'data_id' => $user->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Pengguna ' . $user->name . ' Berhasil Diubah!',
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $exception) {
            $status = 'danger';
            $message = 'Gagal Mengubah Data';
        }
        return redirect('/manajemen/pengguna')->with($status, $message);
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)->first();
        $user->delete();

        Log::create([
            'model' => 'users',
            'data_id' => $user->id,
            'datetime' => date('Y-m-d H:i:s'),
            'message' => 'Pengguna ' . $user->name . ' Berhasil Dihapus!',
            'user_id' => auth()->user()->id,
        ]);

        return redirect('/manajemen/pengguna')->with('success', 'Berhasil Menghapus Data');
    }

    public function redirect_to_employee()
    {
        $user_id = $_GET['user_id'];
        $employee = Employee::where('user_id', $user_id)->first();

        return redirect('/karyawan/' . $employee->id);
    }
}
