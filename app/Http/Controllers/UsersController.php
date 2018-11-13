<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        
        return view('users.index', [
            'users' => $users,
            ]);
    }
    
    public function show($id)
    {
        $user = User::find($id);
        $tasklists = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);

        $data = [
            'user' => $user,
            'tasklists' => $tasklists,
        ];

        $data += $this->counts($user);
        
        return view('users.show',$data);
    }
}
