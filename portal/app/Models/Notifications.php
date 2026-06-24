<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    function sendEmail($to, $subject, $message) {

        $root= $_SERVER['HTTP_HOST'];
        $root = explode('.', $root);
        $postfix = 'staffingsolution';
        if($root[0] != 'wwww'){
            $postfix = $root[0];
        }else{
        $postfix = $root[1];
        }
  
          // $from = 'no-reply@'.$_SERVER['HTTP_HOST'];
          $from = $postfix.'@247staffingsolution.com.au';
          // $from = str_replace('247staffingsolutions', '247staffingsolution', $from);  
  
  // To send HTML mail, the Content-type header must be set
  
          $headers  = 'MIME-Version: 1.0' . "\r\n";
  
          $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  
  // Create email headers
  
          $headers .= 'From: '.$from."\r\n".
  
              'Reply-To: '.$from."\r\n" .
  
              'X-Mailer: PHP/' . phpversion();
  
  // Sending email
          try{
          mail($to, $subject, $message, $headers);
          return true;
          }catch(Exception $e)
          {
  			return false;
          }
      }
}
