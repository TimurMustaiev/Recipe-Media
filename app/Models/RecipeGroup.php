<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeGroup extends Model
{
    use HasFactory;

    protected $primaryKey = 'recipe_group_id';

    protected $table = 'recipe_groups';
    protected $fillable = array('name', 'user_id', 'img_path', 'description', 'access_modificator');
}
