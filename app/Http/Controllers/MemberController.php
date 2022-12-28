<?php

namespace App\Http\Controllers;

use Genocide\Radiocrud\Services\ActionService\ActionService;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use App\Actions\MemberAction;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    // public function signin(Request $request)
    // {
    //     $loginData = $request->validate([
    //         'email' => ['required', 'string'],
    //         'password' => ['required', 'string'],
    //     ]);

    //     $member = Member::where('email', $loginData['email'])->first();

    //     if (!empty($member) && Hash::check($loginData['password'], $member->password)) {
    //         $token = $member->createToken('auth_token');
    //         return response()->json([
    //             'token' => $token->plainTextToken
    //         ]);
    //     }

    //     return response()->json([
    //         'message' => 'login data is incorrect.'
    //     ], 401);
    // }

    public function getInfoByToken(Request $request)
    {
        try {
            $member_id  = $request->user()->id;
            $member = Member::find($member_id);
            return response()->json([
                'status' => 'true',
                'message' => $member->name . ' profile',
                'data' => $member
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'false',
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    public function signin(Request $request)
    {
        $loginData = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $member = Member::where('email', $loginData['email'])->first();

        if (!empty($member) && Hash::check($loginData['password'], $member->password)) {
            $token = $member->createToken('auth_token');
            return response()->json([
                'token' => $token->plainTextToken
            ]);
        }

        return response()->json([
            'message' => 'login data is incorrect.'
        ], 401);
    }

    public function signup(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'name' => 'required | string | max:30',
                'email' => 'required | string | max:50',
                'password' => 'required | string | max:30'
            ]);
            if ($validated->fails()) {
                $error = $validated->errors()->all()[0];
                return response()->json([
                    'status' => 'false',
                    'message' => $error,
                    'data' => []
                ], 422);
            } else {
                $member = new Member();
                $member->name = $request->name;
                $member->email = $request->email;
                $member->password = Hash::make($request->password);
                $result = $member->save();
                if ($result) {
                    return response()->json([
                        'status' => 'true',
                        'message' => 'signup successful',
                        'data' => $member
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'false',
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'name' => 'required | string | max:30',
                'email' => 'required | string | max:50',
                'password' => 'required | string | max:30'
            ]);
            if ($validated->fails()) {
                $error = $validated->errors()->all()[0];
                return response()->json([
                    'status' => 'false',
                    'message' => $error,
                    'data' => []
                ], 422);
            } else {
                $member = Member::find($request->user()->id);
                $member->name = $request->name;
                $member->email = $request->email;
                $member->password = Hash::make($request->password);
                $result = $member->update();
                if ($result) {
                    return response()->json([
                        'status' => 'true',
                        'message' => 'user info updated',
                        'data' => $member
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'false',
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    // public function signup(Request $request)
    // {
    //     return response()->json([
    //         'message' => 'ok',
    //         'data' => (new MemberAction())
    //             ->setRequest($request)
    //             ->setValidationRule('signup')
    //             ->storeByRequest()
    //     ]);
    // }
}
