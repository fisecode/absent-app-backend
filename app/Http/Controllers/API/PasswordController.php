<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class PasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function reset(Request $request)
    {
        $request->validate([
            'password_old' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (Hash::check($request->password_old, $request->user()->password)) {

            $request->user()->update([
                'password' => Hash::make($request->password)
            ]);

            return ResponseFormatter::success(null, 'Password changed successfully.');
        }

        return ResponseFormatter::error([
            'message' => 'Something went wrong',
        ], 'Update Passsword Failed.', 500);
    }
}
