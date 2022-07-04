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
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class AbsentController extends Controller
{
    use ImageStorage;

    public function absent(Request $request)
    {
        try {
            $date                = date("Y-m-d");
            $time                = date("H:i:s");
            $photo               = $request->file('photo');
            $absentType          = $request->type;
            $getEmployee         = Employee::where('user_id', Auth::user()->id)->first();
            $absent              = Absent::where('employee_id', $getEmployee->id)->first();
            $employeeAbsentToday = Absent::where('employee_id', $getEmployee->id)
                ->whereDate('created_at', Carbon::today())
                ->first();

            if ($absentType == 'in') {

                $request->validate([
                    'longitude'   => ['required'],
                    'latitude'    => ['required'],
                    'absent_spot' => ['required'],
                    'address'     => ['required'],
                    'photo'       => ['required'],
                    'type'        => ['in:in,out', 'required'],
                ]);

                if (!$employeeAbsentToday) {
                    $dataAbsent = ([
                        'employee_id' => $getEmployee->id,
                        'date'        => $date,
                        'status'      => null,
                        'check_in'    => $time,
                        'check_out'   => null,
                        'longitude'   => $request->longitude,
                        'latitude'    => $request->latitude,
                        'absent_spot' => $request->absent_spot,
                        'address'     => $request->address,
                        'photo'       => $this->uploadImage($photo, $request->user()->name, 'absent'),
                        'type'        => 'in'
                    ]
                    );
                    $absent->create($dataAbsent);

                    return ResponseFormatter::success(
                        ['absent' => null],
                        'Employee successfully check in'
                    );
                }
                return ResponseFormatter::success(
                    ['absent' => null],
                    'Employee has been checked in'
                );
            }

            if ($absentType == 'out') {
                if ($employeeAbsentToday) {
                    if ($employeeAbsentToday->status == 'Present') {
                        return ResponseFormatter::success(
                            ['absent' => null],
                            'Employee has been checked out'
                        );
                    }
                    $dataAbsent = ([
                        'status'    => 'Present',
                        'check_out' => $time,
                        'type'      => 'out'
                    ]);
                    $employeeAbsentToday->update($dataAbsent);

                    return ResponseFormatter::success(
                        ['absent' => null],
                        'Employee successfully check out'
                    );
                }
                return ResponseFormatter::success(
                    ['absent' => null],
                    'Please do check in first'
                );
            }
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error'   => $error
            ], 'Absent Failed', 500);
        }
    }

    public function history(Request $request)
    {
        $request->validate(
            [
                'from' => ['required'],
                'to'   => ['required'],
            ]
        );

        $getEmployee = Employee::where('user_id', Auth::user()->id)->first();
        $history     = Absent::where('employee_id', $getEmployee->id)
            ->whereBetween(
                DB::raw('DATE(date)'),
                [
                    $request->from, $request->to
                ]
            )->get();

        return ResponseFormatter::success(
            ['absent' => $history],
            'list of presences by user'
        );
    }

    public function absentSpot(Request $request)
    {
        $request->validate([
            'name_spot' => ['required'],
            'latitude'  => ['required'],
            'longitude' => ['required'],
            'address'   => ['required'],
        ]);

        $absentSpot      = new AbsentSpot();
        $getEmployee     = Employee::where('user_id', Auth::user()->id)->first();
        $absentSpotExist = AbsentSpot::where('employee_id', $getEmployee->id)->first();

        if (!$absentSpotExist) {
            $dataAbsentSpot = ([
                'employee_id' => $getEmployee->id,
                'name_spot'   => $request->name_spot,
                'latitude'    => $request->latitude,
                'longitude'   => $request->longitude,
                'address'     => $request->address,
                'status'      => 'Pending'
            ]);
            $absentSpot->create($dataAbsentSpot);
            return ResponseFormatter::success(
                [
                    'absent_spot' => $dataAbsentSpot,
                ],
                'Change request absent spot has been sent.'
            );
        }

        if ($absentSpotExist->status == 'Pending') {
            return ResponseFormatter::error(
                [
                    'absent_spot' => $absentSpotExist
                ],
                'You already request, Wait for approval.'
            );
        }
        $dataAbsentSpot = ([
            'name_spot' => $request->name_spot,
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'address'   => $request->address,
            'status'    => 'Pending'
        ]);
        $absentSpotExist->update($dataAbsentSpot);
        return ResponseFormatter::success(
            [
                'absent_spot' => $dataAbsentSpot,
            ],
            'Change request absent spot has been sent.'
        );
    }

    public function getAbsentSpot()
    {
        $getEmployee   = Employee::where('user_id', Auth::user()->id)->first();
        $getAbsentSpot = AbsentSpot::where('employee_id', $getEmployee->id)->first();
        return ResponseFormatter::success(
            [
                'absent_spot' => $getAbsentSpot,
            ],

            'Get Absent Spot Success'
        );
    }
}
