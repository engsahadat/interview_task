<?php

namespace App\Lib;

use App\Libs\Constants;

class CommonFunction
{

    public static function userRole()
    {
        $role = [
            Constants::ADMIN_ROLE => 'Admin',
            Constants::USER_ROLE => 'User',
        ];

        return $role;
    }



}