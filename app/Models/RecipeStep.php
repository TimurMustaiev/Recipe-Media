<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeStep extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'recipe_step_id';

    protected $table = 'recipe_steps';
    protected $fillable = array('recipe_id', 'ordinal_number', 'description');
}
