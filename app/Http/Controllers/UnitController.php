<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Region;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $region_id = isset($_GET['region_id']) ? $_GET['region_id'] : null;
        $regions = Region::where('id', '>', 1)->get();

        $description = 'Data Unit KSU Abdi Karya ';
        if($region_id) {
            $region = Region::where('id', $region_id)->first();
            
            $units = Unit::where('region_id', $region_id)->get();
            $description .= 'Wilayah ' . $region->name;
        } else {
            $units = Unit::all();
        }


        return view('pages.management.unit.index', [
            'page' => 'Pengaturan',
            'description' => $description,
            'regions' => $regions,
            'units' => $units,
            'region_id' => $region_id,
        ]);
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'region_id' => 'required',
        ]);

        try {
            $unit = Unit::create($validatedData);
            $status = 'success';
            $message = 'Berhasil Menambahkan Data';

            Log::create([
                'model' => 'units',
                'data_id' => $unit->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Unit ' . $unit->name . ' Berhasil Dibuat!',
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $exception) {
            $status = 'error';
            $message = 'Gagal Menambahkan Data';
        }
        return redirect('/manajemen/unit')->with($status, $message);
    }

    public function update(Request $request, Unit $unit)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'region_id' => 'required',
        ]);
        try {
            Unit::where('id', $unit->id)->update($validatedData);
            $status = 'success';
            $message = 'Berhasil Mengubah Data';

            Log::create([
                'model' => 'units',
                'data_id' => $unit->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Unit ' . $unit->name . ' Berhasil Diubah!',
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $exception) {
            $status = 'danger';
            $message = 'Gagal Mengubah Data';
        }
        return redirect('/manajemen/unit')->with($status, $message);
    }
    
    public function destroy(Unit $unit)
    {
        $unit->delete();

        Log::create([
            'model' => 'units',
            'data_id' => $unit->id,
            'datetime' => date('Y-m-d H:i:s'),
            'message' => 'Unit ' . $unit->name . ' Berhasil Dihapus!',
            'user_id' => auth()->user()->id,
        ]);

        return redirect('/manajemen/unit')->with('success', 'Berhasil Menghapus Data');
    }
}
