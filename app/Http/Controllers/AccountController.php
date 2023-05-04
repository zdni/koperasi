<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountLine;
use App\Models\Employee;
use App\Models\Log;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private $state = [
        'draft' => 'Draf',
        'post' => 'Validasi',
        'cancel' => 'Batal'
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
        $accounts = Account::all();

        return view('pages.management.account.index', [
            'page' => 'Dana Jaminan Hari Tua',
            'description' => 'Dana JHT Karyawan KSU Abdi Karya',
            'accounts' => $accounts,
            'months' => $this->months,
            'state' => $this->state,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'period' => 'required',
        ]);
        $url = 'dana-jht';

        try {
            $period = $request->period;
            $month = explode('-', $period)[0];
            $year = explode('-', $period)[1];
            
            $validatedData = [
                'name' => $request->name,
                'state' => 'draft',
                'month' => $month,
                'year' => $year,
            ];

            $account = Account::create($validatedData);
            $status = 'success';
            $message = 'Berhasil Menambahkan Data';

            Log::create([
                'model' => 'accounts',
                'data_id' => $account->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Dokumen ' . $account->name . ' Berhasil Dibuat!',
                'user_id' => auth()->user()->id,
            ]);

            $url = 'input-jht/' . $account->id;
        } catch (\Exception $exception) {
            $status = 'error';
            $message = 'Gagal Menambahkan Data';
        }
        return redirect($url)->with($status, $message);
    }

    public function show(Account $account)
    {
        return view('pages.management.account.detail', [
            'page' => 'Dana Jaminan Hari Tua',
            'description' => 'Input Dana JHT Karyawan KSU Abdi Karya',
            'account' => $account,
            'month' => $this->months[$account->month],
            'state' => $this->state[$account->state],
        ]);
    }

    public function edit(Account $account)
    {
        $employees = Employee::where('activity_state', 1)->where('position_id', '!=', 1)->get();
        return view('pages.management.account.form', [
            'page' => 'Dana Jaminan Hari Tua',
            'description' => 'Input Dana JHT Karyawan KSU Abdi Karya',
            'account' => $account,
            'employees' => $employees,
            'months' => $this->months,
            'state' => $this->state,
        ]);
    }

    public function update(Request $request, Account $account)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'period_' => 'required',
        ]);

        try {
            $period = $request->period_;
            $month = explode('-', $period)[0];
            $year = explode('-', $period)[1];

            $validatedData = [
                'name' => $request->name,
                'month' => $month,
                'year' => $year,
            ];
            Account::where('id', $account->id)->update($validatedData);
            $status = 'success';
            $message = 'Berhasil Mengubah Data';
            
            Log::create([
                'model' => 'accounts',
                'data_id' => $account->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Dokumen ' . $account->name . ' Berhasil Diubah!',
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $exception) {
            $status = 'error';
            $message = 'Gagal Mengubah Data';
        }
        return redirect('dana-jht')->with($status, $message);
    }

    public function cancel(Request $request, Account $account)
    {
        $validatedData = $request->validate([
            'state' => 'required',
            'id' => 'required',
        ]);

        try {
            $id = $request->id;
            Account::where('id', $id)->update($validatedData);
            AccountLine::where('account_id', $id)->update(['state' => 'cancel']);

            $status = 'success';
            $message = 'Dana JHT Berhasil Dibatalkan';
            
            Log::create([
                'model' => 'accounts',
                'data_id' => $account->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Dokumen ' . $account->name . ' Dibatalkan!',
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $exception) {
            $status = 'error';
            $message = 'Gagal Menambahkan Data';
        }
        return redirect('dana-jht')->with($status, $message);
    }

    public function _validate(Request $request, Account $account)
    {
        $validatedData = $request->validate([
            'state' => 'required',
            'id' => 'required',
        ]);

        try {
            $id = $request->id;
            Account::where('id', $id)->update($validatedData);
            AccountLine::where('account_id', $id)->update(['state' => 'post']);

            $status = 'success';
            $message = 'Dana JHT Berhasil Divalidasi';
            
            Log::create([
                'model' => 'accounts',
                'data_id' => $account->id,
                'datetime' => date('Y-m-d H:i:s'),
                'message' => 'Dokumen ' . $account->name . ' Berhasil Divalidasi!',
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $exception) {
            $status = 'error';
            $message = 'Gagal Menambahkan Data';
        }
        return redirect('dana-jht')->with($status, $message);
    }
}
