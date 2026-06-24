<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Feed as feed;


class Feeds extends Controller
{
    public $feed_model;
    public function __construct(Request $request, feed $feed_model) {
        $this->feed_model = $feed_model;
    }

    public function news_and_feeds(){
            
        $odds = [];
        $evens = [];

        $results=DB::table('feed')
        ->join('administrators','feed.post_by_id', '=' ,'administrators.id')
        ->join('acces_level_defination','administrators.access_level_id', '=' ,'acces_level_defination.id')->select(
            'feed.id AS feed_id',
            'administrators.id AS admin_id',
            'administrators.image AS admin_image',
            'administrators.email AS admin_email',
            'administrators.name AS admin_name',
            'acces_level_defination.id AS access_id',
            'acces_level_defination.title AS role_name',
            'feed.html_body',
            'feed.post_by_id',
            'feed.TIMESTAMP_INSERTED AS feed_created_at'
        )->orderBy('feed.id','DESC')->get();
        // return $results;
        // exit();
        foreach($results as $result){
            if($result->feed_id % 2 == 0){
                $comments=DB::table('feed_comments')->where('feed_id',$result->feed_id)->get();
                foreach($comments as $c){
                    $c->created_at=Date("d-m-Y",strtotime($c->created_at));
                }
                $like=DB::table('feed_likes')->where('feed_id',$result->feed_id)->where('liked_by_id',session()->get('userId'))->exists();
                if(!empty($like)){
                    $like_status="liked";
                }else{
                    $like_status="unliked";
                    
                }
                $result->feed_created_at=Date("d-m-Y",strtotime($result->feed_created_at));

                $even[] = [
                    'id'=>$result->feed_id,
                    'name'=>$result->admin_name,
                    'role'=>$result->role_name,
                    'image'=>$result->admin_image,
                    'post_by_id'=>$result->post_by_id,
                    'admin_id'=>$result->admin_id,


                    'html_body'=>$result->html_body,
                    'created'=>$result->feed_created_at,
                    'comments'=>$comments,
                    'like'=>$like_status
                ];
                // $evens = json_decode(json_encode($even), true);
       

                $evens = (object) $even;
            }
            else{
                $result->feed_created_at=Date("d-m-Y",strtotime($result->feed_created_at));

                $comments=DB::table('feed_comments')->where('feed_id',$result->feed_id)->get();
                foreach($comments as $c){
                    $c->created_at=Date("d-m-Y",strtotime($c->created_at));
                }
                $like=DB::table('feed_likes')->where('feed_id',$result->feed_id)->where('liked_by_id',session()->get('userId'))->exists();
                if(!empty($like)){
                    $like_status="liked";
                }else{
                    $like_status="unliked";
                    
                }
                $odd[] =[
                    // 'id'=>$result->id,
                    // 'name'=>$result->post_by_name,
                    // 'role'=>$result->post_by_role,
                    // 'image'=>$result->post_by_image,
                    // 'html_body'=>$result->html_body,
                    // 'created'=>$result->TIMESTAMP_INSERTED,
                    // 'post_by_id'=>$result->post_by_id,

                    // 'comments'=>$comments,
                    // 'like'=>$like_status
                    'id'=>$result->feed_id,
                    'name'=>$result->admin_name,
                    'role'=>$result->role_name,
                    'image'=>$result->admin_image,
                    'post_by_id'=>$result->post_by_id,
                    'admin_id'=>$result->admin_id,


                    'html_body'=>$result->html_body,
                    'created'=>$result->feed_created_at,
                    'comments'=>$comments,
                    'like'=>$like_status

                ];
                // $odds = json_decode(json_encode($odd), true);
                $odds = (object) $odd;

            }
        
        }
    //    return  ['results'=> $results,'evens'=> $evens,'odds'=> $odds];
             return  view('admin/news_and_feeds/news_and_feeds',['results'=> $results,'evens'=> $evens,'odds'=> $odds]);
    }
    public function create_feed(Request $request){
        
        $results=$this->feed_model->create_feed($request->post_by_id,$request->htmlBody);
        if($results){
       return response()->json(array('success' => true ,'feed_id' => $results));
        }
        else{
       return response()->json(array('success' => false));

        }
    }
    public function get_feed(Request $request)

    {
        $result=DB::table('feed')
        ->join('administrators','feed.post_by_id', '=' ,'administrators.id')
        ->join('acces_level_defination','administrators.access_level_id', '=' ,'acces_level_defination.id')->select(
            'feed.id AS feed_id',
            'administrators.id AS admin_id',
            'administrators.image AS admin_image',
            'administrators.email AS admin_email',
            'administrators.name AS admin_name',
            'acces_level_defination.id AS access_id',
            'acces_level_defination.title AS role_name',
            'feed.html_body',
            'feed.post_by_id',
            'feed.TIMESTAMP_INSERTED AS feed_created_at'
        )->where('feed.id',$request->id)->first();
      
        // $results=DB::table('feed')->where('id',$request->id)->get();
        // foreach($result as $r){
        //     $r->feed_created_at=Date("d-m-Y",strtotime($r->feed_created_at));
        // }
        $results[] = [
            'id'=>$result->feed_id,
            'name'=>$result->admin_name,
            'role'=>$result->role_name,
            'image'=>$result->admin_image,
            'post_by_id'=>$result->post_by_id,
            'admin_id'=>$result->admin_id,


            'html_body'=>$result->html_body,
            'created'=>$result->feed_created_at,
         
        ];
        return $results;
    }

    public function post_comment(Request $request)
{

    $results=$this->feed_model->post_comment($request->name,$request->commented_by_id,$request->image,$request->feed_id,$request->message);
    if($results){
   return response()->json(array('success' => true ,'comment_id' => $results));
    }
    else{
   return response()->json(array('success' => false));

    }
}
public function get_comment(Request $request)

{
    $results=DB::table('feed_comments')->where('id',$request->id)->get();
    foreach($results as $result){
        $result->created_at=Date("d-m-Y",strtotime($result->created_at));

    }
    return $results;
}
public function check_like(Request $request){
    $results=DB::table('feed_likes')->where('feed_id',$request->feed_id)->where('liked_by_id',$request->user_id)->exists();
    if(!empty($results)){
        DB::table('feed_likes')->where('feed_id',$request->feed_id)->where('liked_by_id',$request->user_id)->delete();
        return response()->json(array('success' => true ,'liked' =>false,'deleted'=>true));

    }
    else
    {
    $results=DB::table('feed_likes')->insert(['feed_id'=>$request->feed_id,
    'liked_by_id'=>$request->user_id,'liked_by_name' =>session()->get('userName')]);
    if($results){
            return response()->json(array('success' => true,'liked' =>true));

    }
    }
}


public function delete_comment(Request $request){
    $results = DB::table('feed_comments')->where('id',$request->id)->delete();
      return response()->json(array('success' => true ,'liked' =>true));

}
public function delete_feed(Request $request){
    $results = DB::table('feed')->where('id',$request->id)->delete();
      return response()->json(array('success' => true ,'liked' =>true));

}

public function count_likes(Request $request){
    $results = DB::table('feed_likes')->where('feed_id',$request->id)->get();
      return $results;

}
function view_feed_status(Request $request){
    $result=DB::table('feed_seen_status')->join('guards', 'guards.id', '=', 'feed_seen_status.guard_id')
    ->select('name')->where('feed_seen_status.feed_id',$request->id)->where('feed_seen_status.status','seen')->get();
    if(!empty($result)){
        return $result;
    }
}
}
