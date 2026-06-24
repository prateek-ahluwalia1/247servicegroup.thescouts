<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Operation_Note as operation;

class Operation_Notes extends Controller
{
    //
    public $operation_model;
    public function __construct(Request $request, operation $operation_model) {
        $this->operation_model = $operation_model;
    }
    public function create_operation_notes(Request $request){
        $results=DB::table('shiftnotes')->insert([
            'title'=>$request->title,
            'notes'=>$request->notes,
            'toid'=> json_encode($request->toid),
            'fromid'=>$request->fromid,
            'status'=>'unread',
            'seen_users' => json_encode(array())
        ]);
        if($results){
            return response()->json(array('success' => true ));
        }
        else{
            return response()->json(array('success' => false));

        }

    }
    public function get_admin_toid(){
       $results= DB::table('administrators')->select('id','name')->where('id' ,'!=' , session()->get('userId'))->where('status'  , 'active')->get();
        return $results;
    }
    public function get_operations(){
        $ids = [''.session()->get('userId').''];
        $results= DB::table('shiftnotes')
        ->join('administrators','administrators.id','=','shiftnotes.fromId')
        ->select('shiftnotes.*','administrators.name')
        // ->where('shiftnotes.toid' ,session()->get('userId'))
        ->whereJsonContains('shiftnotes.toid' , $ids)
        ->orderBy('created_at', 'desc')
        ->get();
        foreach($results as $result){
            $result->created_at=Date("d-m-Y H:i:s",strtotime($result->created_at));
            $result->toid = json_decode($result->toid, true);

        }
        return $results;
    }
    public function get_operations_send(){
        $results= DB::table('shiftnotes')
        // ->join('administrators','administrators.id','=','shiftnotes.toid')
        ->select('shiftnotes.*')
        ->where('toid', '!=', null)
        ->where('toid', '!=', '')
        ->where('shiftnotes.fromid' ,session()->get('userId'))->get();
        foreach($results as $result){
            $result->toid = json_decode($result->toid, true);
            $name = '';
            foreach ($result->toid as $key => $id) {
                $name .= DB::table('administrators')->where('id', $id)->value('name');
                if ($key > 0 && $key < sizeof($result->toid) - 1) {
                    $name .= ', ';
                }
            }
            $result->name = $name;

            $result->created_at=Date("d-m-Y",strtotime($result->created_at));
    
        }
        return $results;
    }

    public function get_operations_n_times(Request $request){
        $ids = [''.session()->get('userId').''];
        // $firstId = array_shift($ids);
        $results= DB::table('shiftnotes')
        ->join('administrators','administrators.id','=','shiftnotes.fromId')
        ->select('shiftnotes.*','administrators.name')
        // ->whereRaw('JSON_CONTAINS(shiftnotes.toid, \'["' . $firstId . '"]\')')
        // ->whereJsonContains('shiftnotes.toid' , session()->get('userId'))
        ->whereJsonContains('shiftnotes.toid' , $ids)
        ->whereJsonDoesntContain('shiftnotes.seen_users' , $ids)
        // ->whereRaw('not json_contains(shiftnotes.seen_users, \'["'.session()->get('userId').'"]\')')
        ->where('shiftnotes.status'  , 'unread')
        ->orderBy('shiftnotes.id', 'desc')
        ->take($request->times)
        ->get();
        foreach($results as $result){
            $result->created_at=Date("d-m-Y", strtotime($result->created_at));
            $result->toid = json_decode($result->toid, true);
        }
        // return $results;
        if(!empty($results)){
            return response()->json(array('check'=>"yes",'results' =>$results, 'ids' => $ids));
        }else{

            return response()->json(array('check'=>"no",'results' =>$results ));

        }

    }
    
    public function mark_as_read(Request $request){
        $shiftnotes = DB::table('shiftnotes')->where('id',$request->id)->first();
        $ids = json_decode($shiftnotes->seen_users, true);
        if (!empty($ids)) {
        $ids[] = ''.session()->get('userId').'';
        }else{
        $ids = array( 0 => (String)session()->get('userId'));
        }
        $results = DB::table('shiftnotes')->where('id',$request->id)->update(['seen_users'=> json_encode($ids)]);
        return $results;
}
public function detail_popup_operation(Request $request){
    $results=DB::table('shiftnotes')->join('administrators','administrators.id','=','shiftnotes.fromId')->select('shiftnotes.*','administrators.name' )->where('shiftnotes.id' ,$request->id)->get();
    foreach($results as $result){
        $result->created_at=Date("d-m-Y",strtotime($result->created_at));
    }
    return $results;
}
public function get_count_notes()
{
    $result=DB::table('shiftnotes')->where('toid',session()->get('userId'))->where('status','unread')->get();
    $Count=$result->count();
    return response()->json(array('count' =>$Count ));
}
public function most_recent_operation_note(Request $request){
    $ids = [$request->id];
    $results = DB::table('shiftnotes')
    // ->join('administrators','administrators.id','=','shiftnotes.toid')
    ->select('shiftnotes.*')
    // ->where('shiftnotes.toid' ,$request->id)
    ->whereJsonContains('shiftnotes.toid' , $ids)
    ->whereJsonDoesntContain('shiftnotes.seen_users' , $ids)
    // ->whereRaw('not json_contains(shiftnotes.seen_users, \'['.session()->get('userId').']\')')
    ->where('shiftnotes.status' ,'unread')
    ->orderBy('shiftnotes.id', 'desc')
    ->take(1)
    ->get();
    foreach($results as $result){
        $administrator = DB::table('administrators')->where('id', $request->id)->select('name')->first();
        $result->created_at=Date("d-m-Y",strtotime($result->created_at));
        $result->toid = json_decode($result->toid, true);
        $result->name = $administrator->name;
    }
    return $results;

}
}
