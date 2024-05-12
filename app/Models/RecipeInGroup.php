<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeInGroup extends Model
{
    use HasFactory;

    protected $primaryKey = 'recipe_in_group_id';

    protected $table = 'recipes_in_group';
    protected $fillable = array('recipe_group_id', 'recipe_id');
}
