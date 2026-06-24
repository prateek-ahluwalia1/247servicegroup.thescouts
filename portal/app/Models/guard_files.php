<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Guard;


class guard_files extends Model
{
    use HasFactory;
    protected $table = 'guard_files';
    public function guard(){

        return $this->belongsTo(Guard::class,'id');

    }


}
