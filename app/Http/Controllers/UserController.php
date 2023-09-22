<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Role;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return view('users.users', compact('users'));
    }


    public function users_projects($id){
        if($user = User::find($id)){
            if($projects = Project::all()){
                return view('users.project-user', compact('user', 'projects'));
            }
        }

        return redirect()->back();
    }


    public function users_projects_assign($user_id, $project_id){
        if((User::find($user_id)) && (Project::find($project_id))){
            if(!$this->checkUserProject($user_id, $project_id)){
                ProjectUser::create([
                    'project_id' => $project_id,
                    'user_id' => $user_id
                ]);
            }
        }

        return redirect()->back();
    }

    public function users_projects_unassign($user_id, $project_id){
        if((User::find($user_id)) && (Project::find($project_id))){
            if($this->checkUserProject($user_id, $project_id)){
                ProjectUser::where([
                    'project_id' => $project_id,
                    'user_id' => $user_id
                ])->delete();
            }
        }

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required', 'string', 'max:255',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
            'password' => 'required', 'string', 'min:8', 'confirmed',
        ]);

        if($user = $request->all()){
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'role_id' => 2,
            ]);

            return redirect()->route('users.index');
        }

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if($user = User::find($id)){
            $roles = Role::all();
        
            return view('users.edit', compact('user', 'roles'));
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required', 'string', 'max:255',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
            // 'password' => 'required', 'string', 'min:8', 'confirmed',
            'role_id' => 'required',
        ]);

        if($user = User::find($id)){

            $user->update($request->all());

            $users = User::all();

            return view('users.users', compact('users'));

        }

        return redirect()->back();
    }

    /**
     * Check if user is assigned to a project
     */
    public function checkUserProject($user_id, $project_id){
        return ProjectUser::where('user_id', '=', $user_id)->where('project_id', '=', $project_id)->exists();
    }
}
