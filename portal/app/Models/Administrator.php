<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Administrator extends Model
{
    protected $table = 'administrators';
    const ACTIVE_STATUS = 'active';
    const INACTIVE_STATUS = 'inactive';
    const DELETED_STATUS = 'deleted';


    use HasFactory;

    public function log_user_activity($action,$data, $admin_id = 0)
    {
      DB::table('log_user_activities')->insert([
        'action' => $action,
        'user_id' => $admin_id != 0 ? $admin_id : (session()->has('userId') ? session()->get('userId') : 0),
        'user_type' => session()->has('userType') ? session()->get('userType') : 'admin',
        'data' => json_encode($data)
    ]);
      return true;
  }
//     function insert($name,$email){
//         DB::table('administrators')->insert([
//     'email' => $email,
//     'name' => $name
// ]);

//     }
}

