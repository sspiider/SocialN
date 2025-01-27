<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
 /*
    fonction de deconnexion
    -param -> ''
    -(utilise la methode auth du middleware pour verifier l'util connecté)
    - output -> redirection vers homepage
 
 */
    public function logout(){
        auth()->logout();
        return redirect('/');
    }

    /*
    fonction pour choix page d'acceuil
    -param -> ''
    -(utilise la methode auth du middleware pour verifier util)
    - output -> redirection vers homepage or feed
 
 */
    public function showCorrectHomepage(){
        if (auth()->check()) {
            return view('homepage-feed');
        } else {
            return view('homepage');
        }
        
        
    }

    /*
    fonction de authentification
    -param -> request 
    -vars -> incommingFields => table associative
    -(utilise la methode auth du middleware pour valider connection)
    -(cree la session)
    - output -> redirection vers homepage
 
 */

    public function login(Request $request){
        $incommingFields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);
        if (auth()->attempt(['username'=> $incommingFields['loginusername'],'password'=> $incommingFields['loginpassword']])) {
            $request->session()->regenerate();
            return redirect('/');
        } else {
            return redirect('/');
        }
        

    }
/*
    fonction d' inscription
    -param -> request 
    -vars -> incommingFields => table associative
    -(utilise le modele user pour creer un nv utilisateur)
    -(lui authentifier avant redirection)
    - output -> redirection vers homepage
 
 */
    public function register(Request $request){
        $incommingFields = $request->validate([
            'username' => ['required','min:3','max:20',Rule::unique('users','username')],
            'email' => ['required','email',Rule::unique('users','email')],
            'password' => ['required','min:8','max:20','confirmed']
        ]);
       $user= User::create($incommingFields);
       auth()->login($user);

        return redirect('/');
    }

    /**
     * Display the profile for the given user.
     *
     * -param  \App\Models\User  $user
     * -return \Illuminate\View\View
     */
    public function profile(User $user){
        
        return view('profile-posts',['username' => $user->username,
        'posts' =>$user->posts()->latest()->get(),
        'postCount' =>$user->posts()->count()]);
    }
}
