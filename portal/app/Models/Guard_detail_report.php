<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Guard_detail_report extends Model
{
    protected $table = 'guards';
    use HasFactory;
    // ->orderBy('job_new_roster.roster_id', 'desc')->take(50)->get();

    public function get_records(){
        // orderBy('TIMESTAMP_INSERTED', 'desc')->take(50)->
       $results= DB::table('guards');
       return $results;
    }
}
