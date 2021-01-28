<?php
include($dir.'include/mysql.php'); 
include($dir.'include/config.php');
include($dir.'sendgrid/api_sendgrid.php');
include $dir.'sendgrid/vendor/autoload.php'; 

date_default_timezone_set('America/New_York');
set_time_limit(0); //don't let script time out
//cron job command - php /home2/codegeas/backups/newsletters/sendEmailsDaily.php

//debug mode or live mode
$server = $_SERVER['SERVER_NAME'];
if ($server == 'localhost' || $server == 'saintlynewsletters.test') {
	$newline = '<br />';   //debugging newline
	$cronjob = 0;
	
	if($_GET['cronjob'] == 1 || $_GET['live'] == 1) 
		$cronjob = 1; //live mode in localhost
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
	$day = intval($n['day']);
	
	if(is_numeric($day))
	$newslArray[$series][$day] = array(
		'subject' => $n['subject'],
		'file' => $n['file'],
		'html_code' => $n['html_code']
	);
}

if($cronjob == 0){
	//print("<pre>".print_r($newslArray['makemoneysurveys'], true)."</pre>");
}

//series name from DB => list_id from sendgrid
$sendGridList = array(
	'BlackCrimesMatter' => '6d1d107d-9fe7-404e-9e17-94c2a51eea8c',
	'AnimeFanservice' => '1d43f5df-ff51-4542-a472-3f8de8a771f7', 
	'makemoneysurveys' => '4b47a362-1c44-4103-90f2-feeb13cd02c4'
);

$senderNameList = array(
	'BlackCrimesMatter' => array(
		'senderEmail' => 'admin@blackcrimesmatters.com',
		'senderName' => 'BCM'),
	'AnimeFanservice' => array(
		'senderEmail' => 'animefavoritechannel@gmail.com',
		'senderName' => 'Anime Empire'),
	'MakeMoneySurveys' => array(
		'senderEmail' => 'contact@bestpayingsites.com',
		'senderName' => 'Best Paying Surveys'),  
);

echo ' cronjob: '.$cronjob.' ';  

//connect to sendgrid api
$sendGridAPI = new sendGridAPI(SENDGRID_API_KEY);

$count = 0;
foreach($sendGridList as $series => $list_id) {
	
	$senderName = $senderNameList[$series]['senderName'];
	$senderEmail = $senderNameList[$series]['senderEmail'];
	echo $series.' '.$senderName.' '.$senderEmail.' '.$newline; 
	
	//get all contacts in list
	$list = $sendGridAPI -> list_get ($list_id);

	if($cronjob == 0) { //show array of contacts
		//print("<pre>".print_r($list->contact_sample[0], true)."</pre>");
	}
	
	if(!empty($list))
	foreach($list->contact_sample as $contact) {

		$email = $contact->email;
		$first_name = $contact->first_name; 
		$join_date =  $contact->city; //date is stored as city 

		//calculate # of days since added 
		$today = date('Y-m-d', time());
		$todayDT = new DateTime($today);
		
		//check for empty date
		if(empty($join_date)) $join_date = $today;
		$addedDT = new DateTime($join_date);
		
		$newslDay = $addedDT->diff($todayDT)->format("%a");
		
		$thisNewsletter = $newslArray[$series][$newslDay];

		//if match 
		if(is_array($thisNewsletter)) {
			$shortSubject = substr($thisNewsletter['subject'], 0, 25);
			echo $email.' | '.$contact->city.' | ('.$newslDay.') | true | '.$shortSubject.'... | ';
	 
			$html_code = stripslashes($thisNewsletter['html_code']);
		
			//sendgrid send email
			$newsletterData = array(
				'subject' => $thisNewsletter['subject'],
				'senderName' => 'BCM',
				'senderEmail' => $senderEmail,
				'subscriberName' => $first_name,
				'subscriberEmail' => $email,
				'htmlContent' => $html_code
			);

			//send the newsletter - live only
			if($cronjob == 1) {

				$sendgridMail = new \SendGrid\Mail\Mail(); 
				$sendgridClass = new \SendGrid(SENDGRID_API_KEY);

				$response = sendEmail($sendgridClass, $sendgridMail, $newsletterData); 
				
				//print("<pre>".print_r($response, true)."</pre>");

				$statusCode = $response->statusCode() ;
				print 'statusCode: '. $statusCode.' |'; 
				
				if($statusCode == '202') {

					//add to the log table
					$insertLog = "INSERT INTO log_emails_sent (email, newsl_day, series, date_sent) values ('".$email."', '".$newslDay."', '".$series."', '".$today."')";

					$success = $db->query($insertLog); 

					if($success == 1) 
						echo ' 1';
					else
						echo ' 0: '.mysqli_error();
				}
				else {
					print("<pre>".print_r($response, true)."</pre>");
				}
			}	
		}
		else 
			echo ' false';
		
		echo $newline; $count++; 
	}
	
	echo $newline;	
}

$db->close();

?>