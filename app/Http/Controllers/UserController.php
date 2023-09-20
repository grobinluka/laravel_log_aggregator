<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Http\Request;

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
        if($id){
            if(($user = User::findOrFail($id)) && ($projects = Project::all())){
                // foreach($projects as $key => $project){
                //     if($this->checkUserProject($id, $project->id)){
                //         unset($projects[$key]);
                //     }
                // }

                return view('users.project_user', compact('user', 'projects'));
            }
        }

        return redirect()->back();
    }


    public function users_projects_assign($user_id, $project_id){
        if($user_id && $project_id){
            if(!$this->checkUserProject($user_id, $project_id)){
                ProjectUser::create([
                    'project_id' => $project_id,
                    'user_id' => $user_id
                ]);
            }

            return redirect()->back();
        }
    }

    public function users_projects_unassign($user_id, $project_id){
        if($user_id && $project_id){
            if($this->checkUserProject($user_id, $project_id)){
                ProjectUser::where([
                    'project_id' => $project_id,
                    'user_id' => $user_id
                ])->delete();
            }

            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function checkUserProject($user_id, $project_id){
        return ProjectUser::where('user_id', '=', $user_id)->where('project_id', '=', $project_id)->exists();
    }
}
