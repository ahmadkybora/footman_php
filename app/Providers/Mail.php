<?php

namespace App\Providers;

use PHPMailer\PHPMailer\PHPMailer;

class Mail extends ServiceProvider
{
    protected $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer();
        $this->setUp();
    }

    public function setUp()
    {
        $this->mail->isSMTP();
        $this->mail->Mailer = "smtp";
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = 'tls';

        $this->mail->Host = getenv('SMTP_HOST');
        $this->mail->Port = getenv('SMTP_PORT');

        $environment = getenv('APP_ENV');
        if($environment === 'local')
        {
            $this->mail->SMTPOptions = [
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                )
            ];
            $this->mail->SMTPDebug = 2;
        }

        /**
         * auth info
         */
        $this->mail->Username = getenv('EMAIL_USERNAME');
        $this->mail->Password = getenv('EMAIL_PASSWORD');

        $this->mail->isHtml(true);
        $this->mail->singleTo = true;

        /**
         * sender info
         */
        $this->mail->From = getenv('ADMIN_EMAIL');
        $this->mail->FromName = getenv('Footman');

    }

    public function send($data)
    {
        $this->mail->addAddress($data['to'], $data['name']);
        $this->mail->Subject = $data['subject'];
        $this->mail->Body = make($data['view'], array('data' => $data['body']));
        return $this->mail->send();
    }
}