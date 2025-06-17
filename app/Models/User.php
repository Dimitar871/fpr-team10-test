<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Theme;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'team_id'
    ];

    /*
     * Returns if the acticle is read by this user
     */
    public function readArticles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_marks')
            ->withPivot('read')
            ->withTimestamps();
    }

    public function likedArticles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_marks')
            ->withPivot('favourite');
    }

    public function themes()
    {
        return $this->belongsToMany(\App\Models\Theme::class, 'owned_themes')
            ->withPivot('owned', 'equipped');
    }

    public function equippedTheme()
    {
        return $this->themes()->wherePivot('equipped', true)->first();
    }

    public function ownedThemes()
    {
        return $this->themes()->wherePivot('owned', true);
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function isEmployee(): bool
{
     return $this->team_id === 1;
}
}
