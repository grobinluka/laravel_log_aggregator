<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Http\Request;
use App\Models\SeverityLevel;

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
            'title' => 'required|unique:projects,title|max:150|min:6',
            'slug' => 'required|unique:projects,slug|max:30|min:3',
            'description' => 'required|max:1000',
        ]);

        $project = $request->all();

        if($project){
            Project::create($project);

            $projects = Project::all();
            return view('projects.index', compact('projects'));
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($project_id)
    {
        $projectUserCheck = $this->checkUserProject(auth()->user()->id, $project_id);

        if($projectUserCheck){
            $hourCounter = 0;
            $hour24Counter = 0;

            $numOfLogsPerSeverityLevel = [];

            $severityLevels = SeverityLevel::all();

            foreach($severityLevels as $level){
                $numOfLogsPerSeverityLevel[$level->level] = 0;
            }

            $project = Project::find($project_id);

            $projectsUser = ProjectUser::whereProjectId($project->id)
                ->with('logs.severitylevel')
                ->get();

            if($projectsUser){
                foreach($projectsUser as $pu){
                    foreach($pu->logs as $log){

                        if($log->created_at >= Carbon::now()->subHours(1)){
                            $hourCounter++;
                        }

                        if($log->created_at >= Carbon::now()->subDay()){
                            $hour24Counter++;
                        }

                        if (array_key_exists($log->severitylevel->level, $numOfLogsPerSeverityLevel)) {
                            $numOfLogsPerSeverityLevel[$log->severitylevel->level]++;
                        }
                    }
                }
                
                return view('projects.show', compact(
                        'project',
                        'hourCounter',
                        'hour24Counter',
                        'numOfLogsPerSeverityLevel'
                    ));
            }
        }

        return redirect()->route('home');
    }

    /**
     * Display users projects resource.
     */
    public function myProjects()
    {
        $user = User::find(auth()->user()->id);

        if($user){
            $projectsUser = ProjectUser::whereUserId($user->id)->get();
            
            $projectIds = $projectsUser->pluck('project_id')->toArray();
                
            $projects = Project::whereIn('id', $projectIds)->get();

            return view('projects.my-projects', compact('user','projects'));
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
