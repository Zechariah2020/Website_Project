<?php

namespace App\Actions;

use Genocide\Radiocrud\Services\ActionService\ActionService;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberAction extends ActionService
{
    public function __construct()
    {
        $this
            ->setModel(Member::class)
            ->setResource(MemberResource::class)
            ->setValidationRules([
                'signup' => [
                    'email' => ['required', 'string', 'max:100'],
                    'password' => ['required', 'string', 'max:30']
                ],
                'signin' => [
                    'email' => ['required', 'string', 'max:100'],
                    'password' => ['required', 'string', 'max:30']
                ]
            ]);
        parent::__construct();
    }

    // public function getInfoByToken(Request $request)
    // {
    //     $data = $this->getUserFromRequest();
    //     $data = Member::find($data->id);
    //     return response()->json([
    //         'status' => 'true',
    //         'data' => $data
    //     ]);
    // }
}
