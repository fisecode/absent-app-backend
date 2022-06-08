<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Absent;
use App\Models\Employee;
use App\Traits\ImageStorage;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AbsentController extends Controller
{
    use ImageStorage;

    public function store(Request $request)
    {
        try {
            $request->validate([
                'type' => ['required'],
                'longitude' => ['required'],
                'latitude' => ['required'],
                'absent_spot' => ['required'],
                'address' => ['required'],
                'photo' => ['required'],
            ]);


            $date = date("Y-m-d");
            $time = date("H:i:s");
            $photo = $request->file('photo');
            $absentStatus = $request->type;
            $absent = new Absent;
            $employeeAbsentToday = Absent::where('employee_id', Auth::user()->id)
                ->whereDate('created_at', Carbon::today())
                ->first();

            if ($absentStatus == 'in') {
                if (!$employeeAbsentToday) {
                    $dataAbsent = ([
                        'employee_id' => Auth::user()->id,
                        'date' => $date,
                        'status' => 'in',
                        'check_in' => $time,
                        'check_out' => null,
                        'longitude' => $request->longitude,
                        'latitude' => $request->latitude,
                        'absent_spot' => $request->absent_spot,
                        'address' => $request->address,
                        'photoPath' => $this->uploadImage($photo, $request->user()->name, 'absent/' . $request->user()->name),
                    ]
                    );
                    $absent->create($dataAbsent);

                    return ResponseFormatter::success(
                        $dataAbsent,
                        'Employee successfully check in'
                    );
                }
                return ResponseFormatter::success(
                    [],
                    'Employee has been checked in'
                );
            }

            if ($absentStatus == 'out') {
                if ($employeeAbsentToday) {
                    if ($employeeAbsentToday->status == 'Present') {
                        return ResponseFormatter::success(
                            [],
                            'Employee has been checked out'
                        );
                    }
                    $dataAbsent = ([
                        $absent->check_out = $time
                    ]);
                }
            }
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], $this->authFailed, 500);
        }
    }
}
