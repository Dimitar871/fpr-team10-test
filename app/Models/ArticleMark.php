<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleMark extends Model
{
    protected $fillable = [
        'article_id',
        'user_id',
        'read',
        'favourite',
    ];
}
