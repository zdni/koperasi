<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Log;
use App\Models\Region;
use App\Models\Unit;
use App\Models\User;

class DashboardController extends Controller
{
    public function index() {
        $activities = Log::whereIn('model', ['accounts', 'employees', 'regions', 'units', 'users'])->get();

        $query_employees = Employee::where('activity_state', 1)
                        ->where('position_id', '!=', 1);
        
        $total_employees = $query_employees->count();
        $employees = $query_employees->get();
        $regions = Region::count();
        
        $users = User::where('role_id', '>', 1)->count();

        return view('pages.dashboard', [
            'page' => 'Beranda',
            'description' => 'Beranda KSU Abdi Karya',
            'activities' => $activities,
            'total' => (object) [
                'employees' => $total_employees,
                'regions' => $regions,
                'units' => Unit::count(),
                'users' => $users
            ],
            'employees' => $employees,
            'units' => Unit::all(),
        ]);
    }
}
