<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeComment extends Model
{
    use HasFactory;

    protected $primaryKey = 'recipe_comment_id';

    protected $table = 'recipe_comments';
    public $timestamps = false;
    protected $fillable = array('recipe_id', 'user_id', 'description');

    public function user() {
        return $this->belongsTo(User::class, 'user_id');   
    }
}
