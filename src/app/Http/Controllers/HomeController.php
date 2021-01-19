<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private User $user;
    private Auth $auth;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->auth=new Auth;
        $this->user=new User;
        $this->middleware('auth');
        if(!$this->auth::check())
             return redirect(route('login'),302,['message'=>'not authenticated']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $allUsers=$this->user::count();
        $activeUsers=$this->user::where('status','active')->count();
        $inActiveUsers=$this->user::where('status','active')->count();
        $percentActive=[($activeUsers/$allUsers)*100];
        $percentActive=[($inActiveUsers/$allUsers)*100];
        $chartjs = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['active users', 'inactive users'])
            ->datasets([
                [
                    'backgroundColor' => [ '#15a878','#f85d77'],
                    'hoverBackgroundColor' => [ '#15a878','#f85d77'],
                    'data' => [$percentActive, $inActiveUsers]
                ]
            ])
            ->options([]);
        return view('home.index',compact('chartjs'));
    }
}
