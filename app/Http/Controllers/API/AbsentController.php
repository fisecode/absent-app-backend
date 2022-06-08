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

    public function attendance(Request $request)
    {
        try {
            $request->validate([
                'status' => ['required'],
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
            $absent = Absent::create(
                [
                    'employee_id' => Auth::user()->id,
                    'date' => $date,
                    'status' => $request->status,
                    'check_in' => $time,
                    'check_out' => null,
                    'longitude' => $request->longitude,
                    'latitude' => $request->latitude,
                    'absent_spot' => $request->absent_spot,
                    'address' => $request->address,
                    'photoPath' => $this->uploadImage($photo, $request->user()->name, 'absent'),
                ]
            );
            $absent->save();

            return response()->json(
                [
                    'message' => 'Success'
                ],
                Response::HTTP_CREATED
            );
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], $this->authFailed, 500);
        }
    }
}
