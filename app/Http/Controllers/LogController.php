<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use App\Models\SeverityLevel;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projectUser = ProjectUser::with('user', 'project','logs.severityLevel')->get();

        return view('logs.index', compact('projectUser'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($project_id)
    {
        $project = Project::find($project_id);

        if($project){
            $projectUser = ProjectUser::whereProjectId($project->id)->get();

            $check = false;

            foreach($projectUser as $pu){
                if($pu->user_id === auth()->user()->id){
                    $check = true;
                }
            }

            if($check){
                $severitylevels = SeverityLevel::all();

                if($severitylevels){
                    return view('logs.create', compact('project', 'severitylevels'));
                }
            }
        }

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($project_id, Request $request)
    {
        $request->validate([
            'severitylevel' => 'required',
            'description' => 'required|max:1000',
        ]);

        $user = User::find(auth()->user()->id);
        $project = Project::find($project_id);

        if($project && $request && $user){

            $projectUserCheck = $this->checkUserProject($user->id, $project->id);

            if($projectUserCheck){
                $log = $request->all();

                $projectUser_id = ProjectUser::whereProjectId($project->id)
                        ->whereUserId($user->id)
                        ->first()->id;

                $severitylevel = SeverityLevel::find($log['severitylevel']);

                if($severitylevel){
                    Log::create([
                        'project_user_id' => $projectUser_id,
                        'severity_level_id' => $severitylevel->id,
                        'description' => $log['description'],
                    ]);

                    return redirect()->route('log.mylogs');
                }
            }
        }
        
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $projectUser = ProjectUser::whereUserId(auth()->user()->id)
            ->with('user', 'project','logs.severityLevel')
            ->get();

        return view('logs.my-logs', compact('projectUser'));
    }


    public function apiStore(Request $request){

        $api_key = $request->query('api-key');

        $request->validate([
            'user_id' => 'required',
            'project_id' => 'required',
            'severitylevel' => 'required',
            'description' => 'required|max:1000',
        ]);

        $user = User::find($request['user_id']);
        $project = Project::find($request['project_id']);

        if($project && $request && $user){
            $projectUserCheck = $projectUserCheck = $this->checkUserProject($user->id, $project->id);

            if($projectUserCheck){
                $log = $request->all();

                $projectUser_id = ProjectUser::whereProjectId($project->id)
                        ->whereUserId($user->id)
                        ->first()->id;

                $severitylevel = SeverityLevel::find($log['severitylevel']);

                if($severitylevel){
                    Log::create([
                        'project_user_id' => $projectUser_id,
                        'severity_level_id' => $severitylevel->id,
                        'description' => $log['description'],
                    ]);

                    // return new LogResource($request);
                    return response()->json([
                        'success' => 'The log has been successfully published.',
                        'api-key' => $api_key]);
                }
            }
        }

        return response()->json([
            'error' => 'The publication of the log was unsuccessful..',
            'api-key' => $api_key
        ]);
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
