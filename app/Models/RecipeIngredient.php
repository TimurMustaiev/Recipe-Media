<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'recipe_ingredient_id';

    protected $table = 'recipe_ingredients';
    protected $fillable = array('recipe_id', 'name', 'amount', 'unit');

    public function recipe() {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}
