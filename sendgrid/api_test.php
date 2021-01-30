<?php
require 'vendor/autoload.php'; 
include('config.php');
include('api_sendgrid.php');

$sendgridMail = new \SendGrid\Mail\Mail(); 
$sendgridClass = new \SendGrid(SENDGRID_API_KEY);

$sendGridAPI = new sendGridAPI(SENDGRID_API_KEY);
$list_id = '6908666b-313c-4140-8082-99cd156e5f52'; //BCM newsletter
$list_id = '1d43f5df-ff51-4542-a472-3f8de8a771f7'; //Anime newsletter
$list_id = '4b47a362-1c44-4103-90f2-feeb13cd02c4'; //MMS Newsletter
$list_id = 'f9033b09-3a99-4a95-81f9-66a72cd7994d'; //NUS newsletter

$action = $_GET['action'];

if ($action == 'send_email') { //send day 0 email
	
	//get newsl day 0 from db 
	$series = 'AnimeFanservice';
	$query = 'SELECT * FROM newsletters WHERE series="'.$series.'" AND day = "0"';
	$result = mysqli_query($conn, $query);
	$news = $result->fetch_assoc();
	
	//print_r($news);
	//echo $news['html_code'];

	$subscriberName = 'Subscriber Name';
	$subscriberEmail = 'kaiba.corporation.llc@gmail.com';
	$htmlContent = $news['html_code']; 

	$newsletterData = array(
		'subject' => $news['subject'],
		'senderName' => 'Anime Empire',
		'subscriberName' => $subscriberName,
		'subscriberEmail' => $subscriberEmail,
		'htmlContent' => $htmlContent,
	);
	
	sendEmail($sendgridClass, $sendgridMail, $newsletterData); 
	
}
else if ($action == 'single_send') { //single broadcast

	
}
else if ($action == 'contact_add') {
		

	$info = array(
		'list_id' => $list_id,
		'contact' => array(
			'email' => '444@aol.com',
			'first_name' => 'first name',
			'join_date' => date('Y-m-d'),
			),
	);
	
	echo date('Y-m-d').' ';
	//$json = json_encode($info);
	
	$sendGridAPI->contact_add($info);
	
}
else if ($action == 'contact_count') {
	
	$sendGridAPI -> contact_count ($list_id);

}
else if ($action == 'contact_get') {
	
	if($_GET['email']) {
		$contactEmail = $_GET['email'];
	}
	else $contactEmail = 'louie.online.acc@gmail.com';

	$info = array(
		'email' => $contactEmail,
		'list_id' => $list_id
	);
	
	$array = $sendGridAPI -> contact_get ($info);
	
	echo $array->created_at;
}
else if ($action == 'contact_delete') {
	
	$info = array(
		'email' => 'put email here',
		'list_id' => $list_id
	);
	
	$sendGridAPI -> contact_delete ($info);

}
else if ($action == 'list_add') {

	$array = array('name' => 'Make Money Surveys');
	$json = json_encode($array);
	$sendGridAPI -> list_add ($json);
	
}
else if ($action == 'list_get') { 
	
	$list = $sendGridAPI -> list_get ($list_id); 
	
	echo 'name: '.$list->name.' id: '.$list->id.' <br />'; 
	echo 'contact_count: '.$list->contact_count.' <br />';
  
	foreach($list->contact_sample as $contact) { 
		$contactEmail = $contact->email; 
		$output .= '<a href="?action=contact_get&email='.$contactEmail.'">'.$contactEmail.'</a>'.$contact->first_name.' '.$contact->city.'<br />';
	} 
	
	echo $output;

}
else if ($action == 'list_reset') { 
	$dateToReset = '2021-01-30'; 

	$list = $sendGridAPI->list_get ($list_id); 

	echo 'name: '.$list->name.' <br />'; 
	echo 'id: '.$list->id.' <br />'; 
	echo 'contact_count: '.$list->contact_count.' <br />';
  
	foreach($list->contact_sample as $contact) { 
		$contactEmail = $contact->email; 
		$output .= '<a href="?action=contact_get&email='.$contactEmail.'">'.$contactEmail.'</a>'.$contact->first_name.' <br />';

		$info = array(
			'list_id' => $list_id, 
			'contact' => array( 
				'email' => $contactEmail,
				'join_date' => $dateToReset,
			),
		);
		
		$sendGridAPI->contact_add($info);
	} 

}

?>

<p><a href="?action=send_email">?action=send_email</a></p>

<p><a href="?action=contact_add">?action=contact_add</a></p>

<p><a href="?action=contact_delete">?action=contact_delete</a></p>

<p><a href="?action=contact_count">?action=contact_count</a></p>

<p><a href="?action=contact_get">?action=contact_get</a></p>

<p><a href="?action=list_add">?action=list_add</a></p>

<p><a href="?action=list_get">?action=list_get</a></p>

<p><a href="?action=list_reset">?action=list_reset</a></p>