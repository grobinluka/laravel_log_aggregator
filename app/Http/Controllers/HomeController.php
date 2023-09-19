<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use App\Models\ProjectUser;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index');
    }

    public function projects_users(){
        $projects_users = ProjectUser::join('projects', 'project_users.project_id', '=', 'projects.id')
                // ->join('users', 'project_users.user_id', '=', 'users.id') // Join the users table
                ->select('project_users.*')
                // ->where('users.name', 'Luka Grobin') // Replace $userName with the actual user's name
                ->orderBy('projects.title', 'desc')
                ->get();
    
        return view('projects_users', compact('projects_users'));
    }

    public function logs(){
        $logs = Log::all();

        return view('logs', compact('logs'));
    }

    public function test(){

        $test = [];
        for($i=0; $i < 35; $i++) { 
            $test[] = fake()->unique()->colorName();
        }

        return $test;
    }
}
