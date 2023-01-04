<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ForgotPasswordRequest;
use App\Notifications\ResetPasswordVerificationNotification;
use App\Models\Member;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $input = $request->only('email');
        $member = Member::where('email', $input)->first();
        $member->notify(new ResetPasswordVerificationNotification());
        $success['success'] = true;
        return response()->json($success, 200);
    }
}
