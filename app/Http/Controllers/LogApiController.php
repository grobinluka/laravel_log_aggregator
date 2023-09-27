<?php

namespace App\Http\Controllers;

use App\Http\Resources\LogApiResource;
use App\Models\Log;
use App\Models\User;
use App\Models\ApiKey;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use App\Models\SeverityLevel;

class LogApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'api-key' => 'required',
            'uuid' => 'required',
            'severitylevel' => 'required',
            'description' => 'required|max:1000'
        ]);

        $log = $request->all();

        $user = User::whereUuid($log['uuid'])->first();

        $apiKey = ApiKey::whereApiKey($log['api-key'])->first();

        if($user && $apiKey && $log){
            $projectsUsers = ProjectUser::whereUserId($user->id)->get();
    
            foreach($projectsUsers as $pu){
                if($pu->id === $apiKey->project_user_id){
                    $projectUser = $pu;
                }
            }
    
            if($projectUser && $apiKey && $log){
                $severitylevel = SeverityLevel::whereLevel($log['severitylevel'])->first();
    
                if($severitylevel){
                    Log::create([
                        'project_user_id' => $projectUser->id,
                        'severity_level_id' => $severitylevel->id,
                        'description' => $log['description'],
                        'api_key_id' => $apiKey->id
                    ]);
    
                    return LogApiResource::success('The log has been successfully published.');
                }
            }
        }

        return LogApiResource::error('The publication of the log was unsuccessful.');
    }

    public function severityLevels()
    {

        $severityLevels = SeverityLevel::all();

        $levels = [];

        foreach ($severityLevels as $level) {
            $levels[] = $level['level'];
        }

        return response()->json($levels);
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
