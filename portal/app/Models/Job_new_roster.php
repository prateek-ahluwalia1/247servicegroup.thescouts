<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Job;
use App\Models\Guard;
use App\Models\GreenCall;
use App\Models\WelfareCall;
use App\Models\Job_roster_activities;

class Job_new_roster extends Model
{
    use HasFactory;
    protected $table = "job_new_roster";

    function GreenCall()
    {
        return $this->hasMany(GreenCall::class, 'job_id', 'roster_id');
    }

    function WelfareCall()
    {
        return $this->hasMany(WelfareCall::class, 'job_roster_id', 'roster_id');
    }

    function activity()
    {
        return $this->hasOne(Job_roster_activities::class, 'job_roster_id', 'roster_id');
    }

    function Guards()
    {
        return $this->hasOne(Guard::class, 'id', 'guard_id')->select('id', 'name', 'last_seen', 'in_radius');
    }
     function Site()
    {
        return $this->hasOne(Job::class, 'id', 'site_id');
    }
}
