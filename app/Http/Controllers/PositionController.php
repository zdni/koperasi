<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::all();

        return view('pages.management.position.index', [
            'page' => 'Pengaturan',
            'description' => 'Data Position KSU Abdi Karya',
            'positions' => $positions
        ]);
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        try {
            $position = Position::create($validatedData);
            $status = 'success';
            $message = 'Berhasil Menambahkan Data';

            Log::create([
                'model' => 'positions',
                'data_id' => $position->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Jabatan ' . $position->name . ' Berhasil Dibuat!',
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $exception) {
            $status = 'error';
            $message = 'Gagal Menambahkan Data';
        }
        return redirect('/manajemen/jabatan')->with($status, $message);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
        try {
            $position = Position::where('id', $id)->first();

            Position::where('id', $position->id)->update($validatedData);
            $status = 'success';
            $message = 'Berhasil Mengubah Data';

            Log::create([
                'model' => 'positions',
                'data_id' => $position->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Jabatan ' . $position->name . ' Berhasil Diubah!',
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $exception) {
            $status = 'danger';
            $message = 'Gagal Mengubah Data';
        }
        return redirect('/manajemen/jabatan')->with($status, $message);
    }
    
    public function destroy($id)
    {
        $position = Position::where('id', $id)->first();
        $position->delete();

        Log::create([
            'model' => 'positions',
            'data_id' => $position->id,
            'datetime' => date('Y-m-d H:i:s'),
            'message' => 'Jabatan ' . $position->name . ' Berhasil Dihapus!',
            'user_id' => auth()->user()->id,
        ]);

        return redirect('/manajemen/jabatan')->with('success', 'Berhasil Menghapus Data');
    }
}
