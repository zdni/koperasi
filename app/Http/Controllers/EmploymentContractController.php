<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmploymentContract;
use App\Models\Log;
use Illuminate\Http\Request;

class EmploymentContractController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'amount' => 'required',
        ]);
        $employee_id = $request->employee_id;

        try {
            $contract = EmploymentContract::create($validatedData);
            Employee::where('id', $employee_id)->update(['employment_contract_id' => $contract->id]);

            
            $status = 'success';
            $message = 'Berhasil Menambahkan Data';

            Log::create([
                'model' => 'employment_contracts',
                'data_id' => $contract->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Dokumen ' . $contract->name . ' Berhasil Dibuat!',
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $exception) {
            $status = 'error';
            $message = 'Gagal Menambahkan Data';
        }
        return redirect('/karyawan/' . $employee_id )->with($status, $message);
    }

    public function update(Request $request, EmploymentContract $employmentContract)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'amount' => 'required',
        ]);
        $employee_id = $request->employee_id;
        
        try {
            EmploymentContract::where('id', $employmentContract->id)->update($validatedData);
            $status = 'success';
            $message = 'Berhasil Mengubah Data';

            Log::create([
                'model' => 'employment_contracts',
                'data_id' => $employmentContract->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Dokumen ' . $employmentContract->name . ' Berhasil Diubah!',
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $exception) {
            $status = 'danger';
            $message = 'Gagal Mengubah Data';
        }
        return redirect('/karyawan/' . $employee_id )->with($status, $message);
    }
}
