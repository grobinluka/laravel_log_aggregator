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
        $projectuser = ProjectUser::with('user', 'project','logs.severityLevel')->get();

        return view('logs.index', compact('projectuser'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($project_id)
    {
        if($project = Project::find($project_id)){
            $projectUser = ProjectUser::whereProjectId($project_id)->get();

            $check = false;

            foreach($projectUser as $pu){
                if($pu->user_id === auth()->user()->id){
                    $check = true;
                }
            }

            if($check){
                if($severitylevels = SeverityLevel::all()){
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

        if((Project::find($project_id)) && ($request) && ($user_id = User::find(auth()->user()->id)->id)){
            if($projectuser_id = ProjectUser::whereProjectId($project_id)->whereUserId($user_id)->first()->id){
                $log = $request->all();

                $severitylevel = SeverityLevel::find($log['severitylevel']);

                if($severitylevel = SeverityLevel::find($log['severitylevel'])){
                    Log::create([
                        'project_user_id' => $projectuser_id,
                        'severity_level_id' => $severitylevel->id,
                        'description' => $log['description'],
                    ]);

                    return redirect()->route('log.mylogs');
                }
            }
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $projectuser = ProjectUser::whereUserId(auth()->user()->id)->with('user', 'project','logs.severityLevel')->get();

        return view('logs.my-logs', compact('projectuser'));
    }
}
