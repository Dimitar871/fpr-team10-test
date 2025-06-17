<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaryEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'entry_date',
        'mood',
        'energy',
        'stress',
        'highlights',
        'challenges',
        'gratitude',
        'improvements',
    ];

    protected $casts = [
        'entry_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    //Check if user already has an entry for the given date
    public static function hasEntryForDate($userId, $date)
{
        return self::where('user_id', $userId)
            ->whereDate('entry_date', $date)
           ->exists();
    }


    //Check if the entry can still be edited (within 24 hours of creation)
    public function canBeEdited()
    {
        return $this->created_at->diffInHours(now()) < 24;
    }
}
