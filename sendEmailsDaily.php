<?php
$dir = 'include/';
include($dir.'class.phpmailer.php');
include($dir.'class.smtp.php');
include($dir.'mysql.php'); 
include($dir.'config.php');

date_default_timezone_set('America/New_York');
set_time_limit(0); //don't let script time out
//cron job command - php /home2/codegeas/backups/newsletters/sendEmailsDaily.php

//debug mode or live mode
$server = $_SERVER['SERVER_NAME'];
if ($server == 'localhost' || $server == 'saintlynewsletters.test') {
	$newline = '<br />';   //debugging newline
	$cronjob = 0;
	
	if($_GET['cronjob'] == 1 || $_GET['live'] == 1) 
		$cronjob = 1; //live mode override in localhost
}
else { //cron job - newline is \n
	$newline = "\n";
	$cronjob = 1;
}


//get all newsletters and put them into newslArray
$selN = 'SELECT * FROM newsletters ORDER BY series, day asc';
$resN = $db->query($selN);

while($n = $resN->fetch_assoc()) {

	$series = $n['series'];

	if(is_numeric($n['day']))
		$day = intval($n['day']);
	
	//if(is_numeric($day))
	$newslArray[$series][$day] = array(
		'subject' => $n['subject'],
		'file' => $n['file'],
		'html_code' => $n['html_code']
	);
}

if($cronjob == 0) { //display newslArray
	// print("<pre>".print_r($newslArray['AnimeFanservice'], true)."</pre>"); 
	print("<pre>".print_r($smtpArray, true)."</pre>");
}


$output = ' cronjob: '.$cronjob.' ';  

//loop through all contacts by series 
$selS = 'SELECT * FROM '.$subscribersTable.' ORDER BY series asc';
$resS = $db->query($selS);

while($sub = $resS->fetch_assoc()) {

	$emailTo = $sub['email'].' '; 
	$subscribed = $sub['subscribed'];
	//$series = $sub['series'];

	//calculate # of days since added 
	$today = date('Y-m-d', time());
	$todayDT = new DateTime($today);

	//check for empty date
	if(empty($subscribed)) 
		$subscribed = $today;
	
	$addedDT = new DateTime($subscribed);
	
	$newslDay = $addedDT->diff($todayDT)->format("%a");
	
	$thisNewsletter = $newslArray[$series][$newslDay];

	if ($series != $sub['series']) {
		$series = $sub['series'];
		$output .= $series.' '.$newline;
	}

	$output .= $emailTo.' | '.$subscribed.' | ('.$newslDay.') | ';
	if(is_array($thisNewsletter)) {
		$sendEmailSubject = $thisNewsletter['subject'];
		$displayEmailSubject = substr($thisNewsletter['subject'], 0, 25);

		$sendEmailBody = stripslashes($thisNewsletter['html_code']);
		// $sendEmailBody = $thisNewsletter['html_code'];
		$output .= '<b> true </b> | '.$displayEmailSubject.'... '.$newline;

		//send the newsletter - live only
		if($cronjob == 1) {
			//// send email \\\\
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
			
			$mail->Subject  =  $sendEmailSubject;
			$mail->Body     =  $sendEmailBody;
			$mail->AltBody  =  $sendEmailBody;
			
			if(!$mail->Send())
				echo "Message was <b>not</b> sent - ".$mail->ErrorInfo.'<br />';
			else
				echo "Message to $emailTo has been sent<br />";
				
			//// send email \\\\

		}
	}
	else 
		$output .= ' false '.$newline;

}


echo $output;


exit;

//add to log sendgrid_sent_log
$insertLog = "INSERT INTO sendgrid_sent_log (date_sent, log) values ('".$today."', '".$output."')";
$success = $db->query($insertLog); 

if($success == 1) 
	echo ' 1';
else
	echo ' 0: '.mysqli_error();

$db->close();

?>