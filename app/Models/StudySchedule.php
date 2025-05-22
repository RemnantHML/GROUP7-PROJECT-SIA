<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudySchedule extends Model
{
    protected $table = 'study_schedules';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'title', 'scheduled_at', 'description', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
