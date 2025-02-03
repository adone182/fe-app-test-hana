<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    function index()
    {
        return view('user.index');
    }
    function add()
    {
        return view('user.add');
    }
    function edit($user_id)
    {
        return view('user.edit', compact('user_id'));
    }
}
