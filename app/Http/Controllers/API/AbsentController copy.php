<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Traits\ImageStorage;
use Illuminate\Support\Facades\Auth;

class AbsentController extends Controller
{
    use ImageStorage;

    public function store(Request $request)
    {
        try {
            $request->validate([
                'status' => ['required'],
                'longitude' => ['required'],
                'latitude' => ['required'],
                'absent_spot' => ['required'],
                'address' => ['required'],
                'photo' => ['required'],
            ]);

            $photo = $request->file('photo');
            $absentStatus = $request->status;
            $employeeAbsentToday = $request->employee()
                ->absent()
                ->whereDate('created_at', Carbon::today())
                ->first();

            if ($absentStatus == 'in') {
                if (!$employeeAbsentToday) {
                    $date = date("Y-m-d");
                    $time = date("H:i:s");
                    $absent = Employee::where('user_id', Auth::user()->id)->absent()->create(
                        [
                            'Employee_id' => Auth::user()->id,
                            'date' => $date,
                            'status' => $request->status,
                            'check_in' => $time,
                            'check_out' => '',
                            'longitude' => $request->longitude,
                            'latitude' => $request->latitude,
                            'absent_spot' => $request->absent_spot,
                            'address' => $request->address,
                            'photoPath' => $this->uploadImage($photo, $request->user()->name, 'absent'),
                        ]
                    );

                    return response()->json(
                        [
                            'message' => 'Success'
                        ],
                        Response::HTTP_CREATED
                    );
                }
                return response()->json(
                    [
                        'message' => 'User has been checked in',
                    ],
                    Response::HTTP_OK
                );
            }
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], $this->authFailed, 500);
        }
    }
}
