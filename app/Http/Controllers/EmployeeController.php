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
use Illuminate\Support\Facades\Validator;

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
                        'employee_id' => \Auth::user()->employeeIdFormat($data->employee_id),
                        'show_url' => route('employee.show', Crypt::encrypt($data->id))
                    ]);
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return view('layouts._action', [
                        'model' => $data,
                        'action_url' => '',
                        'edit' => route('employee.edit', Crypt::encrypt($data->id)),
                        'edit_url' => '',
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
        $employeeId = \Auth::user()->employeeIdFormat($this->employeeNumber());

        return view('employee.create', compact('employeeId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'dob' => 'required',
                'gender' => 'required',
                'phone' => 'required|numeric',
                'address' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }
        $photo = $request->file('image');

        if ($photo) {
            $request['photo'] = $this->uploadImage($photo, $request->name, 'user');
        }

        $request['password'] = Hash::make($request->password);

        $user = User::create([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'password' => $request['password'],
            'roles'    => 'Employee',
            'photo'    => $request['photo']
        ]);

        $request['user_id'] = $user->id;
        $request['employee_id'] = $this->employeeNumber();

        Employee::create($request->all());

        return redirect()->route('employee.index')->with('success', 'Employee  successfully created.');
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
        $employeeId = \Auth::user()->employeeIdFormat($employee->employee_id);
        return view('employee.show', compact('employee', 'employeePhoto', 'employeeId'));
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
        $employeeId = \Auth::user()->employeeIdFormat($employee->employee_id);
        return view('employee.edit', compact('employee', 'user', 'employeeId'));
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
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'dob' => 'required',
                'gender' => 'required',
                'phone' => 'required|numeric',
                'address' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            session()->flash('error', $messages->first());
            return redirect()->back();
        }
        $employee = Employee::findOrFail($id);
        $user = User::where('id', $employee->user_id)->first();
        $photo = $request->file('image');

        if ($photo) {
            $request['photo'] = $this->uploadImage($photo, $request->name, 'user', true, $user->photo);
        }

        $employee->update($request->all());
        $user->update($request->all());
        return redirect()->route('employee.show', \Illuminate\Support\Facades\Crypt::encrypt($employee->id))->with('success', 'Employee successfully updated.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $user = User::where('id', $employee->user_id)->first();
        $photo = $user->photo;

        if ($photo) {
            $this->deleteImage($photo, 'user');
        }

        $employee->absentSpot->delete();
        $employee->delete();
        $user->delete();
        session()->flash('success', 'User successfully deleted.');
        return redirect()->back();
    }

    public function delete($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employee.delete', compact('employee'));
    }

    function employeeNumber()
    {
        $latest = Employee::latest()->first();
        if (!$latest) {
            return 1;
        }

        return $latest->employee_id + 1;
    }
}
