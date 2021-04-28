<?php
$dir = 'include/';
include($dir.'class.phpmailer.php');
include($dir.'class.smtp.php');
include($dir.'mysql.php'); 
include($dir.'config.php');



$emailSubject = '111 22222222222';
$sendEmailBody = 'yyyyyyyyyyyyyy yyyyyyyyyyy';



	$emailTo = 'kaiba.corporation.llc@gmail.com';
 

	$mail = new PHPMailer();
	$mail->IsSMTP();         // send via SMTP
	$mail->SMTPSecure = 'ssl';
	$mail->Host     = $smtpHost; // SMTP servers
	$mail->SMTPAuth = true;     // turn on SMTP authentication
	$mail->Username = $smtpUsername;  // SMTP username
	$mail->Password = $smtpPassword; // SMTP password
	$mail->From     = $smtpFromEmail;
	$mail->FromName = $smtpFromName;
	$mail->AddAddress($emailTo);  
	$mail->WordWrap = 50; // set word wrap
	$mail->IsHTML(true);  // send as HTML
	
	$mail->Subject  =  $emailSubject;
	$mail->Body     =  $sendEmailBody;
	$mail->AltBody  =  $sendEmailBody;
	
	if($isOptOut) {
		echo '<i>Message was <b>not</b> sent - user opted out of emails</i><br />';    
	}
	else {
		if(!$mail->Send())
		   echo "Message was <b>not</b> sent - ".$mail->ErrorInfo.'<br />';
		else
		   echo "Message to $emailTo has been sent<br />";
	}

?>