<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'due_date',
        'points',
        'completed',
        'goal_id',
        'completed_at'
    ];

    public function goal(): BelongsTo {
        return $this->belongsTo(Goal::class);
    }
}
