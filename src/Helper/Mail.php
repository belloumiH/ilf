<?php

declare(strict_types=1);

namespace App\Helper;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

/**
 * Class Mail.
 */
class Mail
{
    public function send($data)
    {
        $mail = new PHPMailer();  // Cree un nouvel objet PHPMailer
    // $mail->IsSMTP(); // active SMTP
    $mail->SMTPDebug = 3;  // debogage: 1 = Erreurs et messages, 2 = messages seulement
    $mail->SMTPAuth = true;  // Authentification SMTP active
    $mail->SMTPSecure = 'ssl'; // Gmail REQUIERT Le transfert securise
    $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = 'oussema.albouchii@gmail.com';
        $mail->Password = '21877316azertyzazerter.97';
        $mail->SetFrom('oussema.albouchii@gmail.com', 'ilf');
        $mail->Subject = 'test';
        $mail->Body = 'this is a mail test';
        $mail->AddAddress('idrisshosni@ilfconsulting.fr');
        if (!$mail->Send()) {
            var_dump($mail->ErrorInfo);
            die;

            return 'Mail error: '.$mail->ErrorInfo;
        } else {
            return true;
        }
    }
}
