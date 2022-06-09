<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Absent;
use App\Models\AbsentSpot;
use App\Traits\ImageStorage;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AbsentController extends Controller
{
    use ImageStorage;

    public function absent(Request $request)
    {
        try {
            $request->validate([
                'longitude' => ['required'],
                'latitude' => ['required'],
                'absent_spot' => ['required'],
                'address' => ['required'],
                'photo' => ['required'],
                'type' => ['in:in,out', 'required'],
            ]);


            $date = date("Y-m-d");
            $time = date("H:i:s");
            $photo = $request->file('photo');
            $absentType = $request->type;
            $absent = new Absent;
            $employeeAbsentToday = Absent::where('employee_id', Auth::user()->id)
                ->whereDate('created_at', Carbon::today())
                ->first();

            if ($absentType == 'in') {
                if (!$employeeAbsentToday) {
                    $dataAbsent = ([
                        'employee_id' => Auth::user()->id,
                        'date' => $date,
                        'status' => null,
                        'check_in' => $time,
                        'check_out' => null,
                        'longitude' => $request->longitude,
                        'latitude' => $request->latitude,
                        'absent_spot' => $request->absent_spot,
                        'address' => $request->address,
                        'photoPath' => $this->uploadImage($photo, $request->user()->name, 'absent/' . $request->user()->name),
                        'type' => 'in'
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

            if ($absentType == 'out') {
                if ($employeeAbsentToday) {
                    if ($employeeAbsentToday->status == 'Present') {
                        return ResponseFormatter::success(
                            [],
                            'Employee has been checked out'
                        );
                    }
                    $dataAbsent = ([
                        'status' => 'Present',
                        'check_out' => $time,
                        'type' => 'out'
                    ]);
                    $employeeAbsentToday->update($dataAbsent);

                    return ResponseFormatter::success(
                        $dataAbsent,
                        'Employee successfully check out'
                    );
                }
                return ResponseFormatter::success(
                    [],
                    'Please do check in first'
                );
            }
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Absent Failed', 500);
        }
    }

    public function history(Request $request)
    {
        $request->validate(
            [
                'from' => ['required'],
                'to' => ['required'],
            ]
        );

        $history = Absent::where('employee_id', Auth::user()->id)
            ->whereBetween(
                DB::raw('DATE(created_at)'),
                [
                    $request->from, $request->to
                ]
            )->get();

        return ResponseFormatter::success(
            $history,
            'list of presences by user'
        );
    }

    public function absentSpot(Request $request)
    {
        $request->validate([
            'name_spot' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'address' => ['required'],
        ]);

        $absentSpot = new AbsentSpot();
        $absentSpotExist = $absentSpot->where('employee_id', Auth::user()->id)->first();

        if (!$absentSpotExist) {
            $dataAbsentSpot = ([
                'employee_id' => Auth::user()->id,
                'name_spot' => $request->name_spot,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'address' => $request->address,
            ]);
            $absentSpot->create($dataAbsentSpot);
        }
        $dataAbsentSpot = ([
            'name_spot' => $request->name_spot,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address,
        ]);
        $absentSpot->update($dataAbsentSpot);
    }
}
