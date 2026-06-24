<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Feed extends Model
{
    protected $table = 'feed';

    use HasFactory;


    public function create_feed($post_by_id,$html_body){
        // $image1=$this->upload_files($image);
        //     echo $image1;
        // exit();
    $results= DB::table('feed')->insert([
        'post_by_id'=> $post_by_id,
        'html_body'=> $html_body
    ]);
    $id = DB::getPdo()->lastInsertId();

        return $id;
    }

    public function post_comment($name,$commented_by_id,$image,$feed_id,$message){
        $results=DB::table('feed_comments')->insert([
            'name'=>$name,
            'commented_by_id'=>$commented_by_id,
            'image'=>$image,
            'feed_id'=>$feed_id,
            'message'=>$message
        ]);
        $id = DB::getPdo()->lastInsertId();

        return $id;
        }

        function upload_files($image1)
        {
            $image = $this->upload_img($image1);
        if ($image != '') {
            return response()->json(array('success' => true, 'path' => $image));
        }else{
            return response()->json(array('success' => false, 'path' => ''));
    
        }
    }
        function upload_img($key)
    {
    
        $name = '';
    
        // $path = '../../asset_uploads/';
        $public_path = public_path();
    $public_path = str_replace('portal/public', '', $public_path);
    $public_path = str_replace('apis/public', '', $public_path);
    $path = $public_path.'asset_uploads/';
    
        $file_name = time() .'.jpg';
    
        $this->base64_to_jpeg($key, $path . $file_name);
    
        $name = $file_name;
    
        return $name;
    
    }
    
    function base64_to_jpeg($data, $output_file)
    
    {
    
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
        file_put_contents($output_file, $data);
        
    }
}
