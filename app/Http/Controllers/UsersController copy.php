<?php
// use app/Http/Controllers/UserController;


namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function showUserManagementPage () {

        $groups=Group::where('status', true)->get();
        $users = User::all();
  
        return view('clients.groupManagement',compact('groups','users'));
    }


    
    public function index()
    {
        $users = User::all();
        $groups=Group::where('status', true)->get();
        return view('users.index', compact('users','groups'));
    }

    public function create()
    {
        $groups = Group::all();
        return view('users.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'groups' => 'required|array',
            'groups.*' => 'exists:groups,id'
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $user->groups()->attach($request->groups);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }
}
