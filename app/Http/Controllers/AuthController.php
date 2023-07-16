<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dotenv\Validator;
use DB;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::user()) {
            return redirect()->intended('/dashboard');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        // dd($request->all());
        try {
            // dd(Auth::user()->id);
            
            $credentials = $request->validate([
                'email' => 'required|email|max:255',
                'password' => 'required|max:30'
            ]);

            // dd($credentials);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                $id = Auth::user()->id;
                // dd($id);
                DB::table('users')->where('id', $id)->update([
                    'online' => 1,
                    'last_online' =>Carbon::now()
                ]);
                return redirect()->intended('/dashboard');
            }
            return redirect()->back()->with('error_message', 'Invalid email or password!');
        } catch (Exception $e) {
            return redirect()->back()->with('sweet_alert',[
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error : '.$e,
            ]);
        }
    }

    public function signout(Request $request)
    {
        try {
            $id = Auth::user()->id;
            DB::table('users')->where('id', $id)->update([
                'online' => 0,
            ]);
            Auth::logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
     
            return redirect('/');
        } catch (Exception $e) {
            //throw $th;
        }
    }
}
