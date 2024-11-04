<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyModel extends Model
{
    // Define the fillable attributes
    protected $table = 'blogs';
    protected $fillable = [
        'title',
        'author',
        'description',
        'shortDec',
        'image',
    ];
}
