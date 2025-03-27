<?php

/**
 * Utility Helper File
 * We'll define commonly used utility functions here
 */

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\Files\UploadedFile;
use Config\Services;

/**
 * Get setting
 */
if (!function_exists('getSetting')) {

    function getSetting($key)
    {
        return setting()->get('BaseController.' . $key);
    }
}

/**
 * Set setting
 */
if (!function_exists('setSetting')) {

    function setSetting($keys, $value = null)
    {
        if (is_array($keys)) {

            foreach ($keys as $key => $value) {

                setting()->set('BaseController.' . $key, $value);
            }

            return true;
        }

        setting()->set('BaseController.' . $keys, $value);

        return true;
    }
}

/**
 * Get session
 */
if (!function_exists('getSession')) {

    function getSession($key)
    {
        return session()->get($key);
    }
}

/**
 * Set session
 */
if (!function_exists('setSession')) {

    function setSession($key, $value = null)
    {
        is_array($key) ? session()->set($key) : session()->set($key, $value);

        return true;
    }
}


/**
 * Get flashdata
 */
if (!function_exists('getFlashdata')) {

    function getFlashdata($key)
    {
        return session()->getFlashdata($key);
    }
}

/**
 * Set flashdata
 */
if (!function_exists('setFlashdata')) {

    function setFlashdata($key, $value)
    {
        session()->setFlashdata($key, $value);
    }
}


/**
 * Get input method
 */
if (!function_exists('getInputMethod')) {

    function getInputMethod(): string
    {
        return strtolower(Services::request()->getMethod());
    }
}


/**
 * Get user's post format input
 */
if (!function_exists('getPostInput')) {

    function getPostInput($key = null)
    {
        $request = Services::request();

        return !empty($key) ? $request->getPost($key) : $request->getPost();
    }
}

/**
 * Get user's get format input
 */
if (!function_exists('getGetInput')) {

    function getGetInput($key = null)
    {
        $request = Services::request();

        return !empty($key) ? $request->getGet($key) : $request->getGet();
    }
}

/**
 * Get user's post format input
 */
if (!function_exists('getFileInput')) {

    function getFileInput($key): ?UploadedFile
    {
        $request = Services::request();

        return $request->getFile($key);
    }
}

/**
 * Get user's raw format input
 */
if (!function_exists('getRawInput')) {

    function getRawInput($key = null)
    {
        $request = Services::request();

        return !empty($key) ? $request->getRawInputVar($key) : $request->getRawInput();
    }
}


/**
 * Request response
 */
if (!function_exists('jsonResponse')) {

    function jsonResponse($status, $response, $code = 200)
    {
        $response = [
            'status' => $status,
            'response' => $response,
            'responseCode' => $code
        ];

        service('response')->setStatusCode($code != null ? $code : 200)->setJson($response)->send();

        return null;
    }
}

/**
 * Show 404 page not found page
 */
if (!function_exists('show404')) {

    function show404()
    {
        throw PageNotFoundException::forPageNotFound();
    }
}
