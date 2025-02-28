<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use function Termwind\ValueObjects\inheritFromStyles;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'phone' => 'required',
                'password' => 'required'
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                'role' => 0,
            ]);

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            {
                return redirect(route('dashboard'));
            }
            else {
                return redirect()->route('register');
            }
        }
        return view('auth.register');
    }





    // Login
    public function login(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $request->validate([
                'email' => 'required|email',
                'password'=> 'required'
            ]);

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            {
                return to_route('dashboard')->with('success', 'Logged in Successfully');
            }
            else {
                return redirect(route('login'))->with('error', 'Invalid Login Details');
            }
        }
        return view('auth.login');
    }


    //Dashboard
    public function dashboard()
    {
        if (Auth::check())
        {
            if (Auth::user()->role == 1)
            {
                return view('auth.admin.dashboard');
            }
            else {
                return view('auth.dashboard');
            }
        }
        return redirect()->intend('login')->with('message', 'Please Login first');



    }


    //Profile
    public function profile(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $request->validate([
               'name' => 'required|string',
               'phone' => 'required',
            ]);

            $id = Auth::user()->id;
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->save();

            return redirect(route('profile'))->with('success', 'Successfully, profile updated');
        }
        return view('auth.profile');
    }


    // Logout
    public  function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
        return to_route('login')->with('success', 'Logged out successfully');
    }
}
