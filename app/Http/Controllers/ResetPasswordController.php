<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ResetPasswordRequest;
use Ichtrojan\Otp\Otp as Otp;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;

class ResetPasswordController extends Controller
{
    private $otp;

    public function __construct()
    {
        $this->otp = new Otp;
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $otp2 = $this->otp->validate($request->email, $request->otp);
        if (!$otp2->status) {
            return response()->json(['error' => $otp2], 401);
        }
        $member = Member::where('email', $request->email)->first();
        $member->update(['password' => Hash::make($request->password)]);
        $member->tokens()->delete();
        $success['success'] = true;
        return response()->json($success, 200);
    }
}
