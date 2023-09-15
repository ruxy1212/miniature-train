<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'person';

    /**
     *  The attributes that are mass assignable
     * 
     *  @var string[]
     */
    protected $fillable = [
        'name'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
