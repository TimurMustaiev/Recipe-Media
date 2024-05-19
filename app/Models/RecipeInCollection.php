<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeInCollection extends Model
{
    use HasFactory;

    protected $primaryKey = 'recipe_in_collection_id';

    protected $table = 'recipes_in_collection';
    protected $fillable = array('recipe_collection_id', 'recipe_id');
}
