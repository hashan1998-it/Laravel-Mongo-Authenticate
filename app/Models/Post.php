<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Post extends \Jenssegers\Mongodb\Eloquent\Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'content', 'email', 'images'
    ];
}
