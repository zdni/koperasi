<?php

namespace App\Http\Controllers;

use App\Models\AccountLine;
use App\Models\Employee;
use App\Models\Log;
use App\Models\Position;
use App\Models\RegionLeadership;
use App\Models\Religion;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    private $genders = [
        'male' => 'Pria',
        'female' => 'Wanita',
    ];
    private $educations = [
        'elementary school' => 'SD Sederajat',
        'junior high school' => 'SMP Sederajat',
        'senior high school' => 'SMA Sederajat',
        'associate degree' => 'D3',
        'bachelor degree' => 'S1/D4',
        'graduate' => 'S2',
        'postgraduate' => 'S3',
    ];
    private $months = [
        '1' => 'Januari',
        '2' => 'Februari',
        '3' => 'Maret',
        '4' => 'April',
        '5' => 'Mei',
        '6' => 'Juni',
        '7' => 'Juli',
        '8' => 'Agustus',
        '9' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];

    public function index()
    {
        $is_paginate = true;
        if( count(request()->query) ) {
            $query = Employee::where('activity_state', 1);
            if( request()->unit_id ) $query->where('unit_id', request()->unit_id);
            if( request()->position_id ) $query->where('position_id', request()->position_id);
            
            if( request()->unit_id || request()->position_id ) {
                $employees = $query->get();
                $is_paginate = false;
            } else {
                $employees = $query->paginate(9);
            }
        } else {
            $query = Employee::where('activity_state', 1);
            $employees = $query->paginate(9);
        }

        return view('pages.management.employee.index', [
            'page' => 'Data Koperasi',
            'description' => 'Daftar Karyawan KSU Abdi Karya',
            'employees' => $employees,
            'is_paginate' => $is_paginate,
            'state' => ['Nonaktif', 'Aktif'],
        ]);
    }

    public function ex_exmployees()
    {
        $employees = Employee::where('activity_state', 0)->get();

        return view('pages.management.employee.table', [
            'page' => 'Karyawan Non Aktif',
            'description' => 'Daftar Karyawan KSU Abdi Karya Non Aktif',
            'employees' => $employees,
            'state' => ['Nonaktif', 'Aktif'],
        ]);

    }

    public function create()
    {
        $positions = Position::all();
        $religions = Religion::all();
        $units = Unit::all();
        $users = User::where('role_id', '>', 2)->get();
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

        return view('pages.management.employee.form', [
            'url' => '/karyawan',
            'page' => 'Data Karyawan',
            'description' => 'Tambah Karyawan KSU Abdi Karya',
            'method' => 'post',
            'educations' => $this->educations,
            'positions' => $positions,
            'religions' => $religions,
            'units' => $units,
            'user_id' => $user_id,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'place_and_date_of_birth' => 'required',
            'gender' => 'required',
            'religion_id' => 'required',
            'identity_card_number' => 'required',
            'contact_person' => 'required',
            'last_education' => 'required',
            'address' => 'required',
            'date_of_entry' => 'required',
            'position_id' => 'required',
            'unit_id' => 'required',
        ]);

        try {
            if($request->user_id) $validatedData['user_id'] = $request->user_id;
            $validatedData['activity_state'] = 1;

            $employee = Employee::create($validatedData);
            $status = 'success';
            $message = 'Berhasil Menambahkan Data';

            Log::create([
                'model' => 'employees',
                'data_id' => $employee->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Data Karyawan ' . $employee->name . ' Berhasil Ditambahkan!',
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $exception) {
            dd($exception);
            $status = 'error';
            $message = 'Gagal Menambahkan Data';
        }
        return redirect('/karyawan')->with($status, $message);
    }

    public function show(Employee $employee)
    {
        $lines = AccountLine::join('accounts', 'accounts.id', '=', 'account_lines.account_id')
                            ->where('employee_id', $employee->id)
                            ->where('account_lines.state', 'post')
                            ->orderBy('accounts.year', 'ASC')
                            ->orderBy('accounts.month', 'ASC')
                            ->get(['account_lines.*', 'accounts.month as month_', 'accounts.year as year_']);
        
        return view('pages.management.employee.detail', [
            'page' => 'Data Karyawan',
            'description' => 'Detail Karyawan KSU Abdi Karya',
            'educations' => $this->educations,
            'employee' => $employee,
            'genders' => $this->genders,
            'months' => $this->months,
            'lines' => $lines,
        ]);
    }

    public function edit(Employee $employee)
    {
        $positions = Position::all();
        $religions = Religion::all();
        $units = Unit::all();
        $users = User::where('role_id', '>', 2)->get();

        return view('pages.management.employee.form', [
            'url' => '/karyawan/' . $employee->id,
            'page' => 'Data Karyawan',
            'description' => 'Ubah Data Karyawan KSU Abdi Karya',
            'method' => 'put',
            'educations' => $this->educations,
            'employee' => $employee,
            'positions' => $positions,
            'religions' => $religions,
            'units' => $units,
            'user_id' => $employee->user->id ?? null,
            'users' => $users,
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'place_and_date_of_birth' => 'required',
            'gender' => 'required',
            'religion_id' => 'required',
            'identity_card_number' => 'required',
            'contact_person' => 'required',
            'last_education' => 'required',
            'address' => 'required',
            'date_of_entry' => 'required',
            'position_id' => 'required',
            'unit_id' => 'required',
        ]);
        try {
            $validatedData['user_id'] = $request->user_id;
            
            Employee::where('id', $employee->id)->update($validatedData);
            $status = 'success';
            $message = 'Berhasil Mengubah Data';

            Log::create([
                'model' => 'employees',
                'data_id' => $employee->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Data Karyawan ' . $employee->name . ' Berhasil Diubah!',
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $exception) {
            $status = 'danger';
            $message = 'Gagal Mengubah Data';
        }
        return redirect('/karyawan' . '/' . $employee->id)->with($status, $message);
    }

    public function change_activity_state(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'activity_state' => 'required',
        ]);
        
        try {
            Employee::where('id', $employee->id)->update($validatedData);
            $status = 'success';
            $message = $employee->activity_state ? 'Berhasil Mengnonaktifkan Karyawan' : 'Berhasil Mengaktifkan Karyawan';

            Log::create([
                'model' => 'employees',
                'data_id' => $employee->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Data Karyawan ' . $employee->name . ' Berhasil Dinonaktifkan!',
                'user_id' => auth()->user()->id,
            ]);
            
            if($request->activity_state == 0) {
                if( $employee->position_id == 2 ) {
                    RegionLeadership::where('gm_employee_id', $employee->id)->update(['gm_employee_id' => null]);
                } else if( $employee->position_id == 3 ) {
                    RegionLeadership::where('accountant_employee_id', $employee->id)->update(['accountant_employee_id' => null]);
                } else if( $employee->position_id == 4 ) {
                    RegionLeadership::where('coordinator_employee_id', $employee->id)->update(['coordinator_employee_id' => null]);
                }
            }
        } catch (\Exception $exception) {
            $status = 'danger';
            $message = 'Gagal Mengubah Data';
        }

        return redirect('karyawan')->with($status, $message);
    }

    public function take_account(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'id' => 'required',
        ]);
        
        try {
            AccountLine::where('employee_id', $employee->id)->update(['state' => 'out']);
            if($request->change_activity == 'on') {
                Employee::where('id', $employee->id)->update(['activity_state' => 0]);

                Log::create([
                    'model' => 'employees',
                    'data_id' => $employee->id,
                    'datetime' => date('Y-m-d H:i:s'),
                    'message' => 'Data Karyawan ' . $employee->name . ' Berhasil Dinonaktifkan!',
                    'user_id' => auth()->user()->id,
                ]);
                
                if( $employee->position_id == 2 ) {
                    RegionLeadership::where('gm_employee_id', $employee->id)->update(['gm_employee_id' => null]);
                } else if( $employee->position_id == 3 ) {
                    RegionLeadership::where('accountant_employee_id', $employee->id)->update(['accountant_employee_id' => null]);
                } else if( $employee->position_id == 4 ) {
                    RegionLeadership::where('coordinator_employee_id', $employee->id)->update(['coordinator_employee_id' => null]);
                }
            }
            $status = 'success';
            $message = 'Berhasil Mengambil Dana JHT Karyawan';

            Log::create([
                'model' => 'employees',
                'data_id' => $employee->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Dana JHT Karyawan ' . $employee->name . ' Berhasil Diambil!',
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $exception) {
            $status = 'danger';
            $message = 'Gagal Mengubah Data';
        }

        return redirect('karyawan')->with($status, $message);
    }
}
