<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\ApiKey;
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


    public function usersProjects($id){
        $user = User::find($id);

        if($user){
            $projects = Project::all();

            if($projects){
                return view('users.project-user', compact('user', 'projects'));
            }
        }

        return redirect()->route('home');
    }


    public function usersProjectsAssign($user_id, $project_id){
        $user = User::find($user_id);
        $project = Project::find($project_id);

        if($user && $project){
            if(!$this->checkUserProject($user->id, $project->id)){
                ProjectUser::create([
                    'project_id' => $project_id,
                    'user_id' => $user_id
                ]);
            }
        }

        return redirect()->back();
    }

    public function usersProjectsUnassign($user_id, $project_id){
        $user = User::find($user_id);
        $project = Project::find($project_id);

        if($user && $project){
            if($this->checkUserProject($user->id, $project->id)){
                $projectUser = ProjectUser::whereProjectId($project->id)
                    ->whereUserId($user->id)->first();

                ApiKey::whereProjectUserId($projectUser->id)->delete();

                $projectUser->delete();
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

        $user = $request->all();

        $userCheck = User::whereEmail($user['email'])->first();

        if(!$userCheck){
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
        $user = User::find($id);

        if($user){
            $roles = Role::all();
        
            return view('users.edit', compact('user', 'roles'));
        }

        return redirect()->route('home');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required', 'string', 'max:255',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
            'role_id' => 'required',
        ]);

        $user = User::find($id);

        if($user){

            $user->update($request->all());

            $users = User::all();

            return view('users.users', compact('users'));

        }

        return redirect()->route('home');
    }

    /**
     * Check if user is assigned to a project
     */
    public function checkUserProject($user_id, $project_id){

        $project = Project::find($project_id);

        $user = User::find($user_id);

        $projectUser = ProjectUser::whereUserId($user_id)
            ->whereProjectId($project_id)
            ->exists();

        if($project && $user && $projectUser){
            return true;
        }

        return false;
    }
}
