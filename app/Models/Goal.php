<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Goal extends Model
{
    protected $fillable = [
    'title', 'description', 'specific', 'measureable', 'achievable',
    'relevance', 'time_based', 'achieved', 'achieved_by',
    'user_id', 'goal_type', 'team_id'
];

public function tasks(): HasMany {
    return $this->hasMany(Task::class);
}
}
