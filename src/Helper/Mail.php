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
    public function sendService($data)
    {
        $message = '<html><body><p>SERVICE</p>';
        $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
        foreach ($data as $key => $input) {
            $message .= "<tr style='background: #eee;'><td><strong>".$key.':</strong> </td><td>'.$input.'</td></tr>';
        }
        $message .= '</table>';
        $message .= '</body></html>';
        $mail = new PHPMailer();  // Cree un nouvel objet PHPMailer
    // $mail->IsSMTP(); // active SMTP
    $mail->SMTPDebug = 3;  // debogage: 1 = Erreurs et messages, 2 = messages seulement
    $mail->SMTPAuth = true;  // Authentification SMTP active
    $mail->SMTPSecure = 'ssl'; // Gmail REQUIERT Le transfert securise
    $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = 'consulting.ilf@gmail.com';
        $mail->Password = 'R3Fk2bU2wLk32uG';
        $mail->SetFrom('consulting.ilf@gmail.com', 'ilf');
        $mail->Subject = 'service';
        $mail->Body = $message;
        $mail->IsHTML(true);
        $mail->AddAddress('oussema.albouchii@gmail.com');
        if (!$mail->Send()) {
            return false;
        // var _ dump($mail->ErrorInfo);
            // d i e;
            // return 'Mail error: '.$mail->ErrorInfo;
        } else {
            return true;
        }
    }

    public function sendPartenaire($data)
    {
        $message = '<html><body><p>PARTENAIRE</p>';
        $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
        foreach ($data as $key => $input) {
            $message .= "<tr style='background: #eee;'><td><strong>".$key.':</strong> </td><td>'.$input.'</td></tr>';
        }
        $message .= '</table>';
        $message .= '</body></html>';
        $mail = new PHPMailer();  // Cree un nouvel objet PHPMailer
    // $mail->IsSMTP(); // active SMTP
    $mail->SMTPDebug = 3;  // debogage: 1 = Erreurs et messages, 2 = messages seulement
    $mail->SMTPAuth = true;  // Authentification SMTP active
    $mail->SMTPSecure = 'ssl'; // Gmail REQUIERT Le transfert securise
    $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = 'consulting.ilf@gmail.com';
        $mail->Password = 'R3Fk2bU2wLk32uG';
        $mail->SetFrom('consulting.ilf@gmail.com', 'ilf');
        $mail->Subject = 'service';
        $mail->Body = $message;
        $mail->IsHTML(true);
        $mail->AddAddress('oussema.albouchii@gmail.com');
        if (!$mail->Send()) {
            return false;
        // var _ dump($mail->ErrorInfo);
            // d i e;
            // return 'Mail error: '.$mail->ErrorInfo;
        } else {
            return true;
        }
    }
}
