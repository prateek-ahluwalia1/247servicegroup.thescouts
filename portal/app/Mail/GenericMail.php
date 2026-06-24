<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $user;
    public $emailMessage;
    public $subject;
    
    public function __construct($user, $emailMessage, $subject)
    {
        $this->user = $user;
        $this->emailMessage = $emailMessage;
        $this->subject = $subject;
    }

    public function build()
    {
        // $logoFooter = 'https://amgsystem.com.au/uploads/email_footer.png';
        $fromEmail = 'info@vcpgsystem.com.au';
        $fromName = 'VCPG System';

        // $emailContent = 'Hello ' . $this->user->name . ',<br><br>';
        // $emailContent .= $this->emailMessage . '<br><br>';
        // $emailContent .= '<div style="padding-bottom: 10px">Kind regards,<br>';
        // $emailContent .= '<span style="color:blue;">National Operation Center<br>1300 613 975<span><br><br>';
        // $emailContent .= '<span style="font-size:large;font-weight:bold;color:black;">AMG PTY LTD<br>NOC: 1300 613 975<br>M: 0487 966 9778<br>P.O Box 6155 Point Cook Vic 3030<span><br>';
        // $emailContent .= '<span style="font-size:small;font-weight:bold;">E: operations@amgsecurity.com.au<span><br>';
        // $emailContent .= '<span style="font-weight:bold;">W: <a href="https://www.amgsecurity.com.au">www.amgsecurity.com.au</a><span><br><br><br>';
        // $emailContent .= '<img src="' . $logoFooter . '" style="width:100%;float:left;"/>';

        return $this->from($fromEmail, $fromName)
                    ->subject($this->subject)
                    ->view('emails.customMail', ['emailContent' => $this->emailMessage]);
    }
}
