<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $listUsers = User::all();

        return Inertia::render('User/List', compact('listUsers'));
    }

    public function create()
    {
        return Inertia::render('User/Create');
    }

    public function store(Request $request){

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    }
}
