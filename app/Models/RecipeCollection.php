<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeCollection extends Model
{
    use HasFactory;

    protected $primaryKey = 'recipe_collection_id';

    protected $table = 'recipe_collections';
    protected $fillable = array('name', 'user_id', 'img_path', 'description', 'access_modificator');
}
