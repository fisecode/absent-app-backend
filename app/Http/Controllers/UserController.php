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
        return view('user.profile', compact('user'));
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
        return redirect()->back()->with('success', 'User successfully updated.');
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
        return redirect()->back()->with('success', 'Change Password Successfully.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'  => 'required',
                'email' => 'unique:users,email,' . $id,
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            session()->flash('error', $messages->first());
            return redirect()->back();
        }
        $user = User::findOrFail($id);
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
        return redirect()->route('profile')->with('success', 'User  successfully Updated.');
    }

    public function updatePasswordProfile(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'current_password'      => 'required',
                'new_password'          => 'required|min:8',
                'password_confirmation' => 'required|same:new_password',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->route('profile')->with('error', $messages->first());
        }
        $objUser          = Auth::user();
        $request_data     = $request->All();
        $current_password = $objUser->password;
        if (Hash::check($request_data['current_password'], $current_password)) {
            $user_id            = Auth::User()->id;
            $obj_user           = User::find($user_id);
            $obj_user->password = Hash::make($request_data['new_password']);
            $obj_user->save();

            return redirect()->route('profile', $objUser->id)->with('success', 'Password successfully updated.');
        } else {
            return redirect()->route('profile', $objUser->id)->with('error', 'Please enter correct current password.');
        }
    }
}
