<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Recipe;
use App\Models\RecipeCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // public function log_in(Request $request)
    // {   
    //     if ($request->isMethod('post')) {
    //         $user = User::all()->where('email', $request->get('email'))->first();

    //         // if (!$user || Hash::check($request->get('password'), $user->password))
    //         // {
    //         //     return redirect('error');
    //         // }

    //         Auth::login($user);

    //         return redirect(route('main_page'));
    //     }
        
    //     return view('auth-login');
    // }

    public function log_out() {
        Auth::logout();

        return redirect(route('main_page'));
    }
    
    // public function create()
    // {
    //     return view('auth-register');
    // }

    // public function edit()
    // {
        
    // }

    public function show_profile($user_id)
    {        
        $user = User::find($user_id);

        $recent_recipes = $user->recipes()->latest('updated_at')->take(2)->get();

        $recent_recipe_collections = $user->recipe_collections()->where('access_modificator', 'публічна')->latest('updated_at')->take(2)->get();

        return view('profile')->with('user', $user)
                              ->with('recipes', $recent_recipes)
                              ->with('recipe_collections', $recent_recipe_collections)
                              ->with('user_id', $user_id);
    }
}
