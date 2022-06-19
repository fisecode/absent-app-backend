<?php

namespace App\Http\Controllers;

use App\Models\AbsentSpot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class AbsentSpotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $data = User::where('roles', 'ADMIN');
            $data = AbsentSpot::with('employee')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return view('layouts._action', [
                        'model'      => $data,
                        'edit'       => '',
                        'action_url' => route('absentspot.action', $data->id),
                        'edit_url'   => '',
                        'delete_url' => route('absentspot.delete', $data->id),
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

        // $users = User::paginate(5);
        return view('absentspot.index');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $absentSpot = AbsentSpot::findOrFail($id);
        $absentSpot->employee->work_from = 'Office';
        $absentSpot->employee->save();
        $absentSpot->delete();
        return redirect()->route('absentspot.index')->with('success', 'Absent spot successfully deleted.');
    }

    public function delete($id)
    {
        $absentSpot = AbsentSpot::findOrFail($id);
        return view('absentspot.delete', compact('absentSpot'));
    }

    public function action($id)
    {
        $absentSpot = AbsentSpot::findOrFail($id);
        return view('absentspot.action', compact('absentSpot'));
    }

    public function approval(Request $request)
    {
        $absentSpot = AbsentSpot::findOrFail($request->absentspot_id);
        $absentSpot->status = $request->status;
        if ($absentSpot->status == 'Approval') {
            $absentSpot->status = 'Approve';
            $absentSpot->employee->work_from = $absentSpot->name_spot;
        }
        $absentSpot->save();
        $absentSpot->employee->save();
        return redirect()->route('absentspot.index')->with('success', 'Absent Spot status successfully updated.');
    }
}
