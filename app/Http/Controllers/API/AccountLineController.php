<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountLineResource;
use App\Models\AccountLine;
use App\Models\Log;
use Illuminate\Http\Request;
use Validator;

class AccountLineController extends Controller
{
    private $state = [
        'draft' => 'Draf',
        'post' => 'Validasi',
        'out' => 'Keluar',
        'cancel' => 'Batal',
    ];
    
    public function index()
    {
        if( count(request()->query) ) {
            $query = AccountLine::join('employees', 'employees.id', '=', 'account_lines.employee_id')
                                ->where('state', 'draft');
            if( request()->account_id ) $query->where('account_id', request()->account_id);

            $lines = $query->get(['employees.name', 'account_lines.*']);
        } else {
            $lines = AccountLine::all();
        }

        return response()->json([
            'status' => 'success',
            'lines' => AccountLineResource::collection($lines),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'state' => 'required',
            'account_id' => 'required',
            'employee_id' => 'required',
            'user_id' => 'required',
        ]);
        
        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
                'line' => null
            ]);
        }

        $checkData = AccountLine::where('account_id', $request->account_id)
                                ->where('employee_id', $request->employee_id)
                                ->count();
        if($checkData) {
            $message = ['message' => 'Dana JHT untuk Karyawan Terpilih telah diinput!'];
            return response()->json([
                'status' => 'error',
                'message' => $message,
                'line' => null
            ]);
        }

        $line = AccountLine::create([
            'amount' => $request->amount,
            'state' => 'draft',
            'account_id' => $request->account_id,
            'employee_id' => $request->employee_id,
        ]);

        Log::create([
            'model' => 'account_lines',
            'data_id' => $line->id,
            'datetime' => date('Y-m-d H:i:s'),
            'message' => 'Data Dana JHT Berhasil Dibuat!',
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Menambahkan Dana JHT',
            'line' => $line
        ]);
    }

    public function show($id)
    {
        $line = AccountLine::find($id);
        if(is_null($line)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Tidak Ditemukan!'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'line' => $line
        ]);
    }

    public function update(Request $request, AccountLine $line)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'user_id' => 'required',
        ]);
        
        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
                'line' => null
            ]);
        }

        $line->amount = $request->amount;
        $line->save();

        Log::create([
            'model' => 'account_lines',
            'data_id' => $line->id,
            'datetime' => date('Y-m-d H:i:s'),
            'message' => 'Data Dana JHT Berhasil Diubah!',
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Mengubah Dana JHT',
            'line' => $line
        ]);
    }

    public function destroy(Request $request, AccountLine $line)
    {
        $line->delete();

        Log::create([
            'model' => 'account_lines',
            'data_id' => $line->id,
            'datetime' => date('Y-m-d H:i:s'),
            'message' => 'Data Dana JHT Berhasil Dihapus!',
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Menghapus Dana JHT',
            'line' => $line
        ]);
    }
}
