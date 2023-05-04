<?php

namespace App\Exports;

use App\Models\AccountLine;
use App\Models\Employee;
use App\Models\Unit;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
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
    // public function collection()
    // {
    //     return User::all();
    // }
    public function view(): View
    {
        return view('report/pdf/employee/recap', [
            'results' => Employee::where('activity_state', 1)->orderBy('unit_id', 'ASC')->get(),
            'date' => date('d-m-Y'),
            'months' => $this->months,
        ]);
    }
}
