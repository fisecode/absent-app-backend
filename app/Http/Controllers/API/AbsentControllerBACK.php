<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Absent;
use App\Traits\ImageStorage;
use Illuminate\Support\Facades\Auth;

class AbsentController extends Controller
{
    use ImageStorage;

    public function store(Request $request)
    {

        try {
            $request->validate([
                'longitude' => ['required'],
                'latitude' => ['required'],
                'absent_spot' => ['required'],
                'address' => ['required'],
                'photo' => ['required'],
            ]);

            $date = date("Y-m-d");
            $time = date("H:i:s");
            $photo = $request->file('photo');

            $absent = Absent::orderBy('id', 'desc')->where('employee_id', Auth::user()->id)->first();

            if ($absent != null) {
                $absent = Absent::find($absent->id);
                $absent->check_out = $time;
                $absent->save();

                return ResponseFormatter::success(
                    $absent,
                    'Employee Successfully Check Out'
                );
            }

            $checkAbsent = Absent::where('employee_id', Auth::user()->id)->get()->toArray();

            if (empty($checkAbsent)) {
                $employeeAbsent = new Absent();
                $employeeAbsent->employee_id = Auth::user()->id;
                $employeeAbsent->date = $date;
                $employeeAbsent->status = 'Present';
                $employeeAbsent->check_in = $time;
                $employeeAbsent->check_out = null;
                $employeeAbsent->longitude = $request->longitude;
                $employeeAbsent->latitude = $request->latitude;
                $employeeAbsent->absent_spot = $request->absent_spot;
                $employeeAbsent->address = $request->address;
                $employeeAbsent->photoPath = $this->uploadImage($photo, $request->user()->name, 'absent');

                $employeeAbsent->save();

                return ResponseFormatter::success(
                    $employeeAbsent,
                    'Employee Successfully Check In'
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
