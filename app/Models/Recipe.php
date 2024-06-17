<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $primaryKey = 'recipe_id';

    protected $table = 'recipes';
    protected $fillable = array('name', 'cuisine_id', 'meal_type', 'user_id', 'description', 'img_path');

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function recipe_ingredients() {
        return $this->hasMany(RecipeIngredient::class, 'recipe_id');
    }

    public function recipe_steps() {
        return $this->hasMany(RecipeStep::class, 'recipe_id');
    }

    public function recipe_comments() {
        return $this->hasMany(RecipeComment::class, 'recipe_id');
    }

    public function recipe_ratings() {
        return $this->hasMany(RecipeRating::class, 'recipe_id');
    }

    public function cuisine() {
        return $this->belongsTo(Cuisine::class, 'cuisine_id');
    }
}
