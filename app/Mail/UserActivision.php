<?php

namespace App\Mail;

use App\Providers\Mail;

class UserActivision
{
    public function sender()
    {
        $mail = new Mail();
        $data = [
            'to' => 'amontazeri53@gmail.com',
            'subject' => 'welcome to',
            'view' => 'user-activision',
            'name' => 'John Doe',
            'body' => 'Testing mail',
        ];
        if($mail->send($data))
            echo "Email send successfully";
        else
            echo "Email sending failed";
    }
}