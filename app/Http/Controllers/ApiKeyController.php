<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ApiKey;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    /**
     * Display a list of the resources - All API Keys for the Authenticated User's Assigned Project.
     */
    public function index($project_id)
    {
        $projectUserCheck = $this->checkUserProject(auth()->user()->id, $project_id);

        if($projectUserCheck){

            $projectUser = ProjectUser::whereUserId(auth()->user()->id)
                ->whereProjectId($project_id)
                ->first();

            $apiKeys = ApiKey::whereProjectUserId($projectUser->id)->get();

            $project = Project::find($project_id);
                
            return view('projects.api.projects-keys', compact(
                    'project',
                    'apiKeys',
                ));
        
        }

        return redirect()->route('home');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $project_id){


        $projectUserCheck = $this->checkUserProject(auth()->user()->id, $project_id);

        $request->validate([
            'name' => 'required|max:50|min:3|string'
        ]);

        $apiKey = $request->all();

        if($projectUserCheck && $apiKey){
            do{
                $api_key = bin2hex(random_bytes(32));
            } while (ApiKey::where('api_key', $api_key)->exists());
    
            if($apiKey){
                $projectUser = ProjectUser::whereUserId(auth()->user()->id)
                    ->whereProjectId($project_id)
                    ->first();

                ApiKey::create([
                    'project_user_id' => $projectUser->id,
                    'name' => $apiKey['name'],
                    'api_key' => $api_key,
                ]);

                $apiKeys = ApiKey::whereProjectUserId($projectUser->id)->get();

                $project = Project::find($project_id);

                return redirect()->route('projects.apiKeys.index', $project->id);           
    
            } 
        }

        return redirect()->route('home'); 
    }


    /**
     * Delete a resource in storage - SOFTDELETE.
     */
    public function destroy($project_id, $api_key_id){

        $projectUserCheck = $this->checkUserProject(auth()->user()->id, $project_id);

        $apiKey = ApiKey::find($api_key_id);

        if($apiKey && $projectUserCheck){
            $project_id = $apiKey->projectUser->project_id;

            $apiKey->delete();

            if($apiKey->delete()){
                return redirect()->route('projects.apiKeys.index', $project_id);
            }
        }

        return redirect()->back();
    }

    /**
     * Display a list of the resources - All API Keys for the selected User on Assigned Project.
     */
    public function indexApiByAdmin($project_id, $user_id)
    {

        $projectUserCheck = $this->checkUserProjectForAdmin($user_id, $project_id);

        if($projectUserCheck){

            $projectUser = ProjectUser::whereUserId($user_id)
                ->whereProjectId($project_id)
                ->withTrashed()
                ->first();

            $apiKeys = ApiKey::whereProjectUserId($projectUser->id)->get();

            $user = User::find($user_id);

            $project = Project::find($project_id);
                
            return view('projects.api.projects-keys-admin', compact(
                    'user',
                    'project',
                    'apiKeys',
                ));
        
        }

        return redirect()->route('home');
    }



    /**
     * Store a newly created resource in storage by ADMIN.
     */
    public function storeApiByAdmin(Request $request, $project_id, $user_id){

        $projectUserCheck = $this->checkUserProject($user_id, $project_id);

        $request->validate([
            'name' => 'required|max:50|min:3|string',
        ]);

        $apiKey = $request->all();

        if($projectUserCheck && $apiKey){
            do{
                $api_key = bin2hex(random_bytes(32));
            } while (ApiKey::where('api_key', $api_key)->exists());
    
            if($api_key){

                $projectUser = ProjectUser::whereUserId($user_id)
                    ->whereProjectId($project_id)
                    ->first();

                ApiKey::create([
                    'project_user_id' => $projectUser->id,
                    'name' => $apiKey['name'],
                    'api_key' => $api_key,
                ]);

                $apiKeys = ApiKey::whereProjectUserId($projectUser->id)->get();

                $user = User::find($user_id);

                $project = Project::find($project_id);

                return redirect()->route('projects.users.apiKeys.index', [
                        'project_id' => $project->id,
                        'user_id' => $user->id
                    ]);       
    
            } 
        }

        return redirect()->route('home'); 
    }

       /**
     * Delete a resource in storage - SOFTDELETE by Admin.
     */
    public function destroyApiByAdmin($project_id, $user_id, $api_key_id){

        $projectUserCheck = $this->checkUserProject($user_id, $project_id);

        $apiKey = ApiKey::find($api_key_id);

        if($apiKey && $projectUserCheck){
            $project_id = $apiKey->projectUser->project_id;

            $user_id = $apiKey->projectUser->user_id;

            $apiKey->delete();

            if($apiKey->delete()){
                return redirect()
                    ->route(
                        'projects.users.apiKeys.index',
                        ['project_id' => $project_id, 'user_id' => $user_id]
                    );
            }
        }

        return redirect()->back();
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

        /**
     * Check if user is assigned to a project
     */
    public function checkUserProjectForAdmin($user_id, $project_id){

        $project = Project::find($project_id);

        $user = User::find($user_id);

        $projectUser = ProjectUser::whereUserId($user_id)
            ->whereProjectId($project_id)
            ->withTrashed()
            ->exists();

        if($project && $user && $projectUser){
            return true;
        }

        return false;
    }
    
}
