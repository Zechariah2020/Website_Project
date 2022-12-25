<?php

namespace App\Actions;

use Genocide\Radiocrud\Services\ActionService\ActionService;
use App\Models\Member;

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
                ]
            ]);
        parent::__construct();
    }
}
