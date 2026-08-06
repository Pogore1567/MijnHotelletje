<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function show_register(){
        return view('register_form');
    }

    public function show_login(){
        return view('login_form');
    }
    public function register(Request $request){

    $validated = $request->validate([

       'name' => 'required', 
       'email' => 'required|email|unique:users',
       'password' => 'required|min:8'
    ],
    [
       'name.required' => 'Moet de naam bevatten', 
       'email.required' => 'Moet email bevatten',
       'password.required' => 'Moet wachtwoord bevatten'
    ]);
        $validated['password'] = Hash::make($validated['password']);
      User::create($validated);
    
      return redirect()->route('hotels')->with('success', 'Registratie verliep successvol');
    }

     
    public function login(Request $request){

       $credentials = $request->validate([

       'email' => 'required|email',
       'password' => 'required|min:8'
    ],
    [
       'email.required' => 'Moet email bevatten',
       'password.required' => 'Moet wachtwoord bevatten',
       'password.min' => 'Moet minimaal 8 tekens bevatten'
    ]);
 
    if(Auth::attempt($credentials)){
        $request->session()->regenerate();

        return redirect()->intended('hotels');
    }
    
    return back()->withErrors([
        'password' => 'Wachtwoord of email klopt niet'
    ]);

    }

    public function logout(Request $request){
    
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
      return redirect('/hotels');
    }

    public function admin(Request $request){

    $admin_password = 'rulymo_ta_investuyemo';
    
        if($request->input('admin_password') !== $admin_password){
            return back()->withErrors(['admin_password'=> 'U bent geen admin']);
        }

        $credantials = Validator::make($request->all(),
    
    [
        'email' => 'required|email',
        'password'=> 'required|min:8',
        'admin_password'=> 'required'
    ],
    [
        'password.min' => 'Moet minimaal 8 tekens bevatten',
        'password.required' => 'Moet wachtwoord bevatten',
        'email.required' => 'Moet email bevatten'
       ]);

       if($credantials->fails() || $request->input('admin_password') !== $admin_password){
        return back()->withErrors($credantials);
       }

        $data = $credantials->validated();

       if(Auth::attempt(
        
         ['email'=> $data['email'],
        'password'=> $data['password'],

       ]))       
       {
        
        $request->session()->regenerate();
        $user = Auth::user();
        $user->update(['is_admin' => true]); 
        $user->save(); 
       
        return redirect('/hotels')->with('success');
        }
        else {
        return redirect('/admin')->withErrors(['email'=> 'Email of wachtwoord kloppen niet', 'admin_password' => 'U bent geen admin']);
       }
    
}

        public function show_admin_login(){

            return view('admin_login_form');
        }
}
