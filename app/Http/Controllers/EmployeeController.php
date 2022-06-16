<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Traits\ImageStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    use ImageStorage;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $data = User::where('roles', 'ADMIN');
            $data = Employee::all();

            return DataTables::of($data)
                ->addColumn('employee_id', function ($data) {
                    return view('layouts._employee', [
                        'employee_id' => $data->employee_id,
                        'show_url' => route('employee.show', Crypt::encrypt($data->id))
                    ]);
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return view('layouts._action', [
                        'model' => $data,
                        'edit_url' => route('employee.edit', Crypt::encrypt($data->id)),
                        'delete_url' => route('deleteEmployee', $data->id),
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // $users = User::paginate(5);
        return view('employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $photo = $request->file('image');

        if ($photo) {
            $request['photo'] = $this->uploadImage($photo, $request->name, 'profile');
        }

        $request['password'] = Hash::make($request->password);

        User::create($request->all());

        return redirect()->route('employee.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empId = Crypt::decrypt($id);
        $employee = Employee::find($empId);
        $employeePhoto = User::where('id', $employee->user_id)->get()->pluck('photo')->first();
        return view('employee.show', compact('employee', 'employeePhoto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empId = Crypt::decrypt($id);
        $employee = Employee::find($empId);
        $user = User::where('id', $employee->user_id)->first();
        return view('employee.edit', compact('employee', 'user'));
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
    }

    public function deleteEmployee($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employee.delete', compact('employee'));
    }
}
