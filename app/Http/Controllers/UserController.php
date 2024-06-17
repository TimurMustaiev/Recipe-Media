<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Recipe;
use App\Models\RecipeCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function logout() {
        Auth::logout();

        return redirect(route('main_page'));
    }

    public function show_profile($user_id)
    {        
        $user = User::find($user_id);

        $recent_recipes = $user->recipes()->latest('updated_at')->take(2)->get();

        $recent_recipe_collections = $user->recipe_collections()->where('access_modificator', 'публічна')->latest('updated_at')->take(2)->get();

        return view('profile/overview')->with('user', $user)
                              ->with('recipes', $recent_recipes)
                              ->with('recipe_collections', $recent_recipe_collections)
                              ->with('user_id', $user_id);
    }

    public function edit_profile($user_id = null) {
        return view('profile/edit');
    }

    public function update_profile(Request $request, $user_id = null) {
        $rules = ['nickname' => 'required',
                  'img' => ['nullable', 'image'],
                  'email' => ['required', 'string', 'email'],
                  'password' => ['nullable', 'min:8']];
        $validator = Validator::make($request->all(), $rules, ['nickname.required' => "Ім'я Користувача не може бути пустим",
                                                               'img.image' => "Обраний файл не є зображенням",
                                                               'email.required' => 'Електронна пошта не може бути пустою',
                                                               'email.email' => "Введений текст не є електронною поштою",
                                                               'password.min' => "Пароль повинен мати мінімум 8 символів"]);

        if ($validator->fails()) {
            return redirect(route('users.edit_profile'))->withErrors($validator)
                                                        ->withInput();
        }

        $nickname = $request->get('nickname');
        $email = $request->get('email');
        $password = $request->get('password');

        $user = User::find(Auth::user()->user_id);

        if ($user->nickname != $nickname) {
            $user->nickname = $nickname;
        }

        if ($request->hasFile('img')) {
            if ($request->file('img')->isValid()) {
                $img = $request->file('img');
                $img_name = time().'.'.$img->extension();
                $img_path = "images/profile_picture/{$img_name}";
                $img->move(public_path('images/profile_picture'), $img_name);
    
                $user->img_path = $img_path;
            }
        }

        if ($user->email != $email) {
            $user->email = $email;
        }

        if (isset($password)) {
            $user->password = bcrypt($password);
        }

        $user->save();

        return redirect(route('main_page'));
    }
}
