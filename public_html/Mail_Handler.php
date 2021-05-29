<?php
function SendMail($username, $object, $body, $codice){
  require_once('PHPMailer/PHPMailerAutoload.php');

  $email = "pn_trasporti_esame@libero.it";
  $password = 'EsameDiStato';
  $port = 465;
  $from = 'PN_Trasporti';
  $subject = 'Codice di verifica PN_Trasporti';
  $mail = new PHPMailer();

  $mail = new PHPMailer;
  $mail->IsSMTP();
  $mail->Host = 'smtpoit.secureserver.net';
  $mail->Port = $port;
  $mail->SMTPAuth = true;
  $mail->Username = $email;
  $mail->Password = $password;
  $mail->SMTPSecure = '';
  $mail->From = $email;
  $mail->FromName = $from;
  $mail->AddAddress($username);
  $mail->IsHTML(true);
  $mail->Subject = $subject;
  $mail->Body = $body;
  if($mail -> Send()){
    echo '<script> alert("Controlli la casella di posta.")</script>';
  }
  else {
    $messaggio = $mail -> ErrorInfo;
    echo $messaggio;
    return false;
  }
  return true;
}

?>
