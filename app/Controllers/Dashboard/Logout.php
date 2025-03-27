<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class Logout extends BaseController
{
    public function index()
    {
        /**
         * Destroy session and redirect to login page
         */
        session()->destroy();

        return redirect()->route('route.admin.login');
    }
}
