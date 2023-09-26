<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    /**
     * Display a list of the resources - All API Keys for the Authenticated User's Assigned Project.
     */
    public function index($id)
    {
        $project = Project::find($id);
        $projectUser = ProjectUser::whereUserId(auth()->user()->id)
            ->whereProjectId($id)
            ->first();

        if($projectUser && $project){

            $apiKeys = ApiKey::whereProjectUserId($projectUser->id)->get();
                
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

        $project = Project::find($project_id);

        $projectUser = ProjectUser::whereUserId(auth()->user()->id)
            ->whereProjectId($project_id)->first();

        $request->validate([
            'name' => 'required|max:50|min:3|string'
        ]);

        $apiKey = $request->all();

        if($project && $projectUser && $apiKey){
            do{
                $api_key = bin2hex(random_bytes(32));
            } while (ApiKey::where('api_key', $api_key)->exists());
    
            if($apiKey){
                ApiKey::create([
                    'project_user_id' => $projectUser->id,
                    'name' => $apiKey['name'],
                    'api_key' => $api_key,
                ]);

                $apiKeys = ApiKey::whereProjectUserId($projectUser->id)->get();

                return redirect()->route('projects.apiKeys.index', ['id' => $project->id]);           
    
            } 
        }

        return redirect()->route('home'); 
    }

    public function destroy($id){

        $apiKey = ApiKey::find($id);

        if($apiKey){
            $project_id = $apiKey->projectUser->project_id;

            $apiKey->delete();

            if($apiKey->delete()){
                return redirect()->route('projects.apiKeys.index', ['id' => $project_id]);
            }
        }

        return redirect()->back();
    }
    
}
