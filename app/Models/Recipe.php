<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $primaryKey = 'recipe_id';

    protected $table = 'recipes';
    protected $fillable = array('name', 'country_kitchen_id', 'user_id', 'description', 'creation_datetime', 'img_path');

    // public function groups()
    // {
    //     return $this->belongsToMany(RecipeGroup::class, 'recipes_in_group', 'recipe_id', 'recipe_group_id');
    // }

    public function recipe_ingredients() {
        return $this->hasMany(RecipeIngredient::class, 'recipe_id');
    }

    public function recipe_steps() {
        return $this->hasMany(RecipeStep::class, 'recipe_id');
    }

    public function recipe_comments() {
        return $this->hasMany(RecipeComment::class, 'recipe_id');
    }
}
