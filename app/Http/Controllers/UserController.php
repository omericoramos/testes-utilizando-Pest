<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $listUsers = User::all();
  
        return Inertia::render('User/List', compact('listUsers'));
    }

}
