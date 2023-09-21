<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\SeverityLevel;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:projects,title|max:150|min:10',
            'slug' => 'required|unique:projects,slug|max:30|min:3',
            'description' => 'required|max:1000',
        ]);

        if($project = $request->all()){
            Project::create($project);

            $projects = Project::all();
            return view('projects.index', compact('projects'));
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if($project = Project::find($id)){
            $hourCounter = 0;
            $hour24Counter = 0;

            $numOfLogsPerSeverityLevel = [];

            $severityLevels = SeverityLevel::all();

            foreach($severityLevels as $level){
                $numOfLogsPerSeverityLevel[$level->level] = 0; 
            }


            if($projectsUser = ProjectUser::whereProjectId($project->id)->with('logs')->get()){
                foreach($projectsUser as $pu){
                    foreach($pu->logs as $log){
                        if($log->created_at >= Carbon::now()->subHours(1)){
                            $hourCounter++;
                        }

                        if($log->created_at >= Carbon::now()->subDay()){
                            $hour24Counter++;
                        }
                    }
                }
                
                return view('projects.show', compact('hourCounter', 'hour24Counter'));
            }
        }


        return redirect()->back();
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

    public function my_projects(){
        if($user = User::find(auth()->user()->id)){
            $projectsUser = ProjectUser::whereUserId($user->id)->get();
            
            $projectIds = $projectsUser->pluck('project_id')->toArray();
                
            $projects = Project::whereIn('id', $projectIds)->get();

            return view('projects.my-projects', compact('user','projects'));
        }
    }
}
