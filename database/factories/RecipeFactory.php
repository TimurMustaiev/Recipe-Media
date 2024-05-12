<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Recipe;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Recipe::class;

    public function definition()
    {
        // $userIds = User::pluck('user_id')->toArray();
        
        return [
            'name'=>'смачний рецепт',
            // 'user_id'=>$this->faker->randomElement($userIds),
            'user_id'=>1,
            'cuisine_id'=>1,
            'meal_type'=>'головна страва',
            'description'=>$this->faker->realText(),
            'creation_datetime'=>$this->faker->date(),
            'img_path'=>'images/recipe_picture/recipe_1.jpg'
        ];
    }
}
