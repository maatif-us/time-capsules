<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capsule extends Model
{
    use HasFactory;
    protected $table = 'capsules';
    
    protected $fillable = [
        'message',
        'created_by',
        'opened_by',
        'opened_at',
        'openeing_time',
    ];

    public function getRemainingTimeAttribute()
    {
        $now = Carbon::now();
        $openingTime = Carbon::parse($this->openeing_time);
        return $now <= $openingTime ? $now->diffInMilliseconds($openingTime) : null;
    }

    public function openedBy()
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
