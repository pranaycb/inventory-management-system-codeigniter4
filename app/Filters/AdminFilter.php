<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (empty(getSession('admin_id'))) {

            return redirect()->route('route.admin.login');
        }

        if (empty(getSession('auth_token'))) {

            return redirect()->route('route.admin.login');
        }

        $admin = model('App\Models\Admin')->find(getSession('admin_id'));

        if (empty($admin)) {

            return redirect()->route('route.admin.login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
