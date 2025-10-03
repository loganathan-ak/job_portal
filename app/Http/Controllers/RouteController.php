<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    function welcome() {
    return view('welcome');
    }

    function showRegister() {
    return view('auth.register');
    }

    function showLogin() {
    return view('auth.login');
    }

    function showSettings() {
    return view('settings');
    }


    
}
