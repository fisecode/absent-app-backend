<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Traits\ImageStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ImageStorage;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::where('roles', 'admin')->paginate(9);

        // $users = User::paginate(5);
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'     => 'required',
                'email'    => 'required|unique:users',
                'password' => 'required',
                'image'    => 'required|image|max:2048'
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            session()->flash('error', $messages->first());
            return redirect()->back();
        }
        $photo = $request->file('image');

        if ($photo) {
            $request['photo'] = $this->uploadImage($photo, $request->name, 'user');
        }

        $request['password'] = Hash::make($request->password);
        $request['roles'] = 'Admin';

        User::create($request->all());
        session()->flash('success', 'User Created.');
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
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
                'email' => 'unique:users,email,' . $id,
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            session()->flash('error', $messages->first());
            return redirect()->back();
        }
        $user = User::findOrFail($id);
        $employee = Employee::where('user_id', 'id');
        $photo = $request->file('image');

        if ($photo) {
            $request['photo'] = $this->uploadImage($photo, $request->name, 'user', true, $user->photo);
        }

        if ($request->password) {
            $request['password'] = Hash::make($request->password);
        } else {
            $request['password'] = $user->password;
        }

        $user->update($request->all());
        $employee->update($request->all());
        session()->flash('success', 'User successfully updated.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $photo = $user->photo;

        if ($photo) {
            $this->deleteImage($photo, 'user');
        }

        $user->delete();
        session()->flash('success', 'User successfully deleted.');
        return redirect()->back();
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        return view('user.delete', compact('user'));
    }

    public function showPassword($id)
    {
        $user = User::findOrFail($id);
        return view('user.password', compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate(
            [
                'password' => 'required|min:8',
                'password_confirmation' => 'required|same:password',
            ]
        );
        $user = User::find($id);
        $request_data = $request->All();
        $user->password = Hash::make($request_data['password']);
        $user->save();
        session()->flash('success', 'Change Password Successfully.');
        return redirect()->back();
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }
}
