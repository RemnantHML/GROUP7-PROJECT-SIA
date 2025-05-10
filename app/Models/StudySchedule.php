<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudySchedule extends Model
{
    // Table name, if different from the default (plural of class name)
    protected $table = 'study_schedules';  

    // The primary key is assumed to be 'id' by default
    protected $primaryKey = 'id';

    // Disable timestamps if you're not using created_at and updated_at
    public $timestamps = true;

    // The attributes that are mass assignable (make sure you include 'id')
    protected $fillable = [
        'title', 'scheduled_at', 'description',
    ];
}
