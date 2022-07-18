<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Exports\ExportLeave;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Leave::with('employee', 'leaveType')->orderBy('created_at', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return view('layouts._leave', [
                        'model'      => $data,
                        'action_url' => route('leave.action', $data->id),
                        'edit_url' => route('leave.edit', $data->id),
                        'delete_url' => route('leave.delete', $data->id),
                    ]);
                })
                ->addColumn('status', function ($data) {
                    return view('layouts._status', [
                        'status' => $data->status
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('leave.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leave = Leave::findOrFail($id);
        $employees = Employee::all();
        $leaveTypes = LeaveType::all();
        return view('leave.edit', compact('leave', 'employees', 'leaveTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'leave_type_id' => 'required',
                'start_date'    => 'required',
                'end_date'      => 'required',
                'leave_reason'  => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->route('leave.index')->with('error', $messages->first());
        }

        $leave = Leave::findOrFail($id);
        $tgl1 = strtotime($request->start_date);
        $tgl2 = strtotime($request->end_date);
        $days = $tgl2 - $tgl1;
        $totalDays = $days / 60 / 60 / 24 + 1;
        $leave['total_leave_days'] = $totalDays;
        $leave->update($request->all());
        return redirect()->route('leave.index')->with('success', 'Leave successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->delete();
        return redirect()->route('leave.index')->with('success', 'Leave successfully deleted.');
    }

    public function delete($id)
    {
        $leave = Leave::findOrFail($id);
        return view('leave.delete', compact('leave'));
    }

    public function action($id)
    {
        $leave = Leave::findOrFail($id);
        return view('leave.action', compact('leave'));
    }

    public function approval(Request $request)
    {
        $leave = leave::findOrFail($request->leave_id);
        $leave->status = $request->status;
        if ($leave->status == 'Approved') {
            $leave->status = 'Approved';
        }
        $leave->save();
        return redirect()->route('leave.index')->with('success', 'Absent Spot status successfully updated.');
    }

    public function exportLeaves(Request $request)
    {
        return Excel::download(new ExportLeave, 'leaves.xlsx');
    }
}
