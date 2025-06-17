<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Theme extends Model
{
    protected $fillable = [
        'title',
        'main_color',
        'sub_color',
        'accent_color',
        'edit_color',
        'delete_color',
        'create_color',
        'background_color',
        'extra_color',
        'text_color',
        'points',
    ];

    public $timestamps = false;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'owned_themes')
            ->withPivot(['owned', 'equipped']);
    }

}
