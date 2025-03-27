<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class Logout extends BaseController
{
    public function index()
    {
        /**
         * Destroy session and redirect to login page
         */
        session()->destroy();

        return redirect()->route('route.user.login');
    }
}
