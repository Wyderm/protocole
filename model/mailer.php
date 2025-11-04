<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php';

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->SMTPAuth = false;

$mail->Host = 'postfix.man.cavm';
$mail->SMTPSecure = true;
$mail->Port = 25;
$mail->SMTPAutoTLS = false;
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => true,
        'verify_peer_name' => true,
        'allow_self_signed' => false
    )
);


$mail->isHTML(true);

return $mail;