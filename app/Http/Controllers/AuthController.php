<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ChangePasswordRequest;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Display a profile
     */
    public function profile()
    {
        return view('auth.profile');
    }

    public function picture(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $request->validate([
            'picture' => ['required']
        ]);

        $data['picture'] = request()->file('picture')->store('profile');

        if(Storage::has(Auth::user()->picture)) {
            Storage::delete(Auth::user()->picture);
        }

        User::find(Auth::user()->id)->update($data);

        return back()->with(['success' => 'Your Picture has been Updated']);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        if(!Hash::check($request->old,Auth::user()->password)) {
            return back()->withErrors(['new' => 'Password Wrong']);
        }

        User::find(Auth::user()->id)->update([
            'password' => Hash::make($request->password)
        ]);
        return back()->with(['success' => 'Password has been Changed']);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();
        
        $data['picture'] = request()->file('picture')->store('profile');

        User::create($data);

        return to_route('index')->with(['success' => 'User has been created']);
    }

    /**
     * Login
     */
    public function login(LoginRequest $request)
    {
        if(Auth::attempt($request->validated())){
            request()->session()->regenerate();
            return to_route('index')->with(['success' => 'You Are logged in']);
        }
        return to_route('auth.login')->withErrors(['name' => 'Wrong Credentials']);
    }


    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return to_route('index')->with(['success' => 'You Are logged out']);
        
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
}
