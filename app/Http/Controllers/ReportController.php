<?php

namespace App\Http\Controllers;

use App\Models\AccountLine;
use App\Models\Employee;
use App\Models\Unit;
use Illuminate\Http\Request;

use PDF;

class ReportController extends Controller
{
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

    public function get_active_employee_fund_report(Request $request)
    {
        $employee_id = implode(',', $request->employee_id ?? []);
        $unit_id = implode(',', $request->unit_id ?? []);
        return redirect('laporan/karyawan-aktif?employee_id=' . $employee_id . '&unit_id=' . $unit_id . '&type=' . $request->type .'&data=' . $request->data . '&model=' . $request->model);
    }

    public function report()
    {
        $employee_id = ( request()->employee_id ) ?  explode(',', request()->employee_id) : null;
        $unit_id = ( request()->unit_id ) ? explode(',', request()->unit_id) : null;
        $type = request()->type;
        $data = request()->data;
        $model = request()->model;
        
        if($model == 'employee') {
            $query = Employee::where('activity_state', 1);
            if( $employee_id ) $query->whereIn('id', $employee_id);
            $query->orderBy('unit_id', 'asc');
            $results = $query->get();
            
            if($data == 'detail') {
                foreach ($results as $employee) {
                    $lines = AccountLine::where('account_lines.state', 'post')
                                ->where('employee_id', $employee->id)
                                ->join('accounts', 'accounts.id', '=', 'account_lines.account_id')
                                ->get(['account_lines.amount', 'account_lines.state', 'accounts.month', 'accounts.year']);
                    $employee->lines = $lines;
                }
            }
        } else if($model == 'unit') {
            $results = Unit::all();
            if( $unit_id ) $results = Unit::whereIn('id', $unit_id)->get();
            if($data == 'detail') {
                foreach ($results as $unit) {
                    foreach ($unit->employees as $employee) {
                        $lines = AccountLine::where('account_lines.state', 'post')
                                    ->where('employee_id', $employee->id)
                                    ->join('accounts', 'accounts.id', '=', 'account_lines.account_id')
                                    ->get(['account_lines.amount', 'account_lines.state', 'accounts.month', 'accounts.year']);
                        $employee->lines = $lines;
                    }
                }
            }
        } else {
            return redirect('beranda');
        }

        if($type == 'pdf') {
            $pdf = PDF::loadview('report/pdf/' . $model . '/' . $data, [
                'results' => $results,
                'date' => date('d-m-Y'),
                'months' => $this->months,
            ]);
            return $pdf->stream('Laporan Jaminan Hari Tua Karyawan.pdf');
        }
        if($type == 'excel') {
        
        }
    }

    public function get_inactive_employee_fund_report()
    {
        $employees = Employee::where('activity_state', 0)->get();
        $pdf = PDF::loadview('report/pdf/employee/ex', [
            'date' => date('d-m-Y'),
            'employees' => $employees,
        ]);
        return $pdf->stream('Laporan Karyawan Non Aktif.pdf');
    }
}
