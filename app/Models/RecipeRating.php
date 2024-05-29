<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeRating extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'recipe_rating_id';

    protected $table = 'recipe_ratings';
    protected $fillable = array('recipe_rating_id', 'recipe_id', 'user_id', 'value');

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}
