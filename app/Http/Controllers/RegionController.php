<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Log;
use App\Models\Region;
use App\Models\RegionLeadership;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $gm_employees = Employee::where('activity_state', 1)->where('position_id', 2)->get();
        $accountant_employees = Employee::where('activity_state', 1)->where('position_id', 3)->get();
        $coo_employees = Employee::where('activity_state', 1)->where('position_id', 4)->get();
        $regions = Region::all();

        return view('pages.management.region.index', [
            'page' => 'Pengaturan',
            'description' => 'Data Wilayah KSU Abdi Karya',
            'regions' => $regions,
            'gm_employees' => $gm_employees,
            'coo_employees' => $coo_employees,
            'accountant_employees' => $accountant_employees,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        try {
            $region = Region::create($validatedData);
            $status = 'success';
            $message = 'Berhasil Menambahkan Data';

            Log::create([
                'model' => 'regions',
                'data_id' => $region->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Wilayah ' . $region->name . ' Berhasil Dibuat!',
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $exception) {
            $status = 'error';
            $message = 'Gagal Menambahkan Data';
        }
        return redirect('/manajemen/wilayah')->with($status, $message);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);
        try {
            $region = Region::where('id', $id)->first();

            Region::where('id', $region->id)->update($validatedData);
            $status = 'success';
            $message = 'Berhasil Mengubah Data';

            Log::create([
                'model' => 'regions',
                'data_id' => $region->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Wilayah ' . $region->name . ' Berhasil Dibuat!',
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $exception) {
            $status = 'danger';
            $message = 'Gagal Mengubah Data';
        }
        return redirect('/manajemen/wilayah')->with($status, $message);
    }

    public function set_region_leaderships(Request $request)
    {
        $validatedData = $request->validate([
            'gm_employee_id' => 'required',
            'coordinator_employee_id' => 'required',
            'accountant_employee_id' => 'required',
            'region_id' => 'required',
        ]);
        try {
            $region_leadership = RegionLeadership::where('region_id', $request->region_id)->first();
            if( $region_leadership ) {
                RegionLeadership::where('id', $region_leadership->id)->update($validatedData);
            } else {
                RegionLeadership::create($validatedData);
            }
            
            $status = 'success';
            $message = 'Berhasil Mengubah Administrasi Wilayah';
            
            $region = Region::where('id', $request->region_id)->first();
            Log::create([
                'model' => 'regions',
                'data_id' => $region->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Administrasi Wilayah ' . $region->name . ' Berhasil Diubah!',
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $exception) {
            $status = 'danger';
            $message = 'Gagal Mengubah Administrasi Wilayah';
        }
        return redirect('/manajemen/wilayah')->with($status, $message);
    }

    public function destroy($id)
    {
        $region = Region::where('id', $id)->first();
        $region->delete();
        
        Log::create([
            'model' => 'regions',
            'data_id' => $region->id,
            'datetime' => date('Y-m-d H:i:s'),
            'message' => 'Administrasi Wilayah ' . $region->name . ' Berhasil Dihapu!',
            'user_id' => auth()->user()->id,
        ]);

        return redirect('/manajemen/wilayah')->with('success', 'Berhasil Menghapus Data');
    }
}
