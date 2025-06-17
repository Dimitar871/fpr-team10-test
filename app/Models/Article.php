<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'author'
    ];

    /*
     * return if the true if the user has read the article
     */
    public function readers() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'article_marks')
            ->withPivot('read')
            ->withTimestamps();
    }

    public function likers() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'article_marks')
            ->withPivot('favourite');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }
}
