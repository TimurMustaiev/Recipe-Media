<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'user_role_id';

    protected $table = 'user_roles';
    protected $fillable = array('name');
}
