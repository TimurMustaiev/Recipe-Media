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
}
