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
        $projects = ProjectUser::whereUserId(auth()->user()->id)
            ->with('project', 'user')
            ->get();

        return view('index', compact('projects'));
    }

}
