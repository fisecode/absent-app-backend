<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absent;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $employees = Employee::whereHas('user', function ($u) {
            $u->where('roles', 'employee');
        })->get();

        $absentTodays = Absent::where('date', Carbon::today())->get();

        return view('dashboard', compact('employees', 'absentTodays'));
    }
}
