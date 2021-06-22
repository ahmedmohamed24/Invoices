<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    private User $user;
    private Auth $auth;
    private Hash $hash;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->auth = new Auth();
        $this->user = new User();
        $this->hash = new Hash();
        $this->middleware('auth');
        if (!$this->auth::check()) {
            return redirect(route('login'), 302, ['message' => 'not authenticated']);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $allUsers = $this->user::count();
        $inActiveUsers = $this->user::where('status', 'active')->count();
        $percentActive = [($inActiveUsers / $allUsers) * 100];
        $chartjs = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['active users percent', 'inactive users percent'])
            ->datasets([
                [
                    'backgroundColor' => ['#15a878', '#f85d77'],
                    'hoverBackgroundColor' => ['#15a878', '#f85d77'],
                    'data' => [$percentActive, $inActiveUsers],
                ],
            ])
            ->options([])
        ;

        return view('home.index', compact('chartjs'));
    }

    public function getProfileSettings()
    {
        return view('home.profile-settings');
    }

    public function saveProfileSettings(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => 'required|string',
            'newPassword' => ['required_with:rePassword', 'same:rePassword', 'min:8'],
            'rePassword' => 'required|min:8',
        ]);
        if (!$this->hash::check($request->password, $request->user()->password)) {
            return back()->withErrors([
                'password' => ['The provided password does not match our records.'],
            ]);
        }
        $this->user::findOrFail($this->auth::user()->id)->update([
            'name' => $request->name,
            'password' => $this->hash::make($request->newPassword),
        ]);

        return back()->with('msg', 'successfully updated');
    }
}
