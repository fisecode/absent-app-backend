<?php

namespace App\Http\Controllers\API;

use App\Models\Leave;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function leave(Request $request)
    {
        try {
            $request->validate([
                'leave_type_id' => ['required'],
                'start_date' => ['required', 'date'],
                'end_date' => ['required', 'date'],
                'leave_reason' => ['required'],
            ]);

            $date = date("Y-m-d H:i:s");
            $tgl1 = strtotime($request->start_date);
            $tgl2 = strtotime($request->end_date);
            $days = $tgl2 - $tgl1;
            $totalDays = $days / 60 / 60 / 24 + 1;

            $leave = Leave::create([
                'employee_id' => Auth::user()->id,
                'leave_type_id' => $request->leave_type_id,
                'applied_on' => $date,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_leave_days' => $totalDays,
                'leave_reason' => $request->leave_reason,
                'status' => 'Pending'
            ]);

            return ResponseFormatter::success(
                $leave,
                'Leave has been sent'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Leave Request Failed', 500);
        }
    }

    public function history()
    {
        $history = Leave::where('employee_id', Auth::user()->id)->with('leaveType')->get();

        return ResponseFormatter::success(
            $history,
            'List of Leave History'
        );
    }
}
