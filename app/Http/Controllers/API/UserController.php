<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;

class UserController extends Controller
{
    use PasswordValidationRules;

    private $authFailed;

    public function __construct()
    {
        $this->authFailed = 'Authentication Failed';
    }

    public function login(Request $request)
    {
        try {
            //validasi input
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            //Mengecek credentials (login)
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], $this->authFailed, 500);
            }

            //Jika User tidak ada tampilkan error
            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new InvalidArgumentException('Invalid Credentials');
            }
            if ($user->roles != 'employee') {
                throw new InvalidArgumentException('Invalid Credentials');
            }

            //Jika User ada maka berhasil Login
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], $this->authFailed, 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules()
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),

            ]);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'User Registered');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something whent wrong',
                'error' => $error
            ], $this->authFailed, 500);
        }
    }

    public function addEmployee(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules(),
                'gender' => ['required', 'string'],
                'phone' => 'numeric',
                'address' => 'required',
                'employee_id' => ['required', 'unique:employees'],
                'work_from' => 'required'
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'roles' => 'employee'
            ]);
            $user->save();

            $employee = Employee::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'dob' => $request->dob,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'address' => $request->address,
                'employee_id' => $request->employee_id,
                'doj' => $request->doj,
                'division' => $request->division,
                'work_from' => $request->work_from,
            ]);
            $employee->save();

            return ResponseFormatter::success(
                $employee,
                'Employee Added'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something whent wrong',
                'error' => $error
            ], $this->authFailed, 500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function fetch(Request $request)
    {
        $employeeDetail = Employee::with('user')->where('user_id', Auth::user()->id)->get();
        return ResponseFormatter::success(
            $employeeDetail,
            'Data employee berhasil diambil'
        );
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();

        $user = Auth::user();
        $employee = Employee::where('user_id', Auth::user()->id);
        $user->update($data);
        $employee->update($data);
        $employeeDetail = Employee::with('user')->where('user_id', Auth::user()->id)->get();

        return ResponseFormatter::success($employeeDetail, 'Profile Updated');
    }

    public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|max:2048'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error([
                'error' => $validator->errors()
            ], 'Update photo fails', 401);
        }

        if ($request->file('file')) {
            $file = $request->file->store('assets/user', 'public');

            $user = Auth::user();
            $user->profile_photo_path = $file;
            $user->update();

            return ResponseFormatter::success([
                $file
            ], 'File successfully uploaded');
        }
    }
}
