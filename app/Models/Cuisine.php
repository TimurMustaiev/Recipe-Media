<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuisine extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'cuisine_id';

    protected $table = 'cuisines';
    protected $fillable = array('name');
}
