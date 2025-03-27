<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class UserFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (empty(getSession('user_id'))) {

            return redirect()->route('route.user.login');
        }

        if (empty(getSession('auth_token'))) {

            return redirect()->route('route.user.login');
        }

        $user = model('App\Models\User')->find(getSession('user_id'));

        if (empty($user)) {

            return redirect()->route('route.user.login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
