<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(){
        return Inertia::render('Users/View', [
            'users' => \App\Models\User::query()
                ->when(\Illuminate\Support\Facades\Request::input('search'), function($query, $search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->paginate(10)
                ->withQueryString()
                ->through(fn($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]),
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
            'can' => [
                'createUser' => true,
            ],
        ]);
    }

    public function create(){
        return Inertia::render('Users/Create');
    }
    public function store(Request $request){


        $request->validate([
            'name' => 'required',
            'email' => 'email|required',
            'password' => 'required',
        ]);
        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return to_route('users.index');
    }

}
