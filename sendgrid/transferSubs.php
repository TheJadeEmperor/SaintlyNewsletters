<?php
include($dir.'include/mysql.php'); 
include($dir.'include/config.php');
include($dir.'include/ee_api.php');
//cron job command - php /home2/codegeas/backups/elasticEmail/transferSubs.php?debug=0
global $db;

set_time_limit(0); 

//debug mode or live mode
$debug = $_GET['debug']; 


if($debug == 1) //debugging newline
	$newline = '<br />';
else //cron job - newline is \n
	$newline = "\n";


$elasticList = array(
	'NeobuxUltimateStrategy' => array(
		'next' => 'PTCPrograms',
		'publicListID' => '9f67619a-9535-449c-b1d8-3e15c6ce4f3f'
	), 
	'PTCPrograms' => array(
		'next' => 'MakeMoneySurveys',
		'publicListID' => '0df6f4ee-ccca-4740-b6f3-721e6e5a70a2'
	), 
	'MakeMoneySurveys' => array(
		'next' => 'OnlineJobs',
		'publicListID' => '4e29b9a7-155a-4526-b306-b70cdf294b31'
	),  
	'OnlineJobs' => array(
		'next' => 'PaypalBooster',
		'publicListID' => 'f5800328-6230-4818-818b-5454b98257c0'
	),  
	'PaypalBooster' => array( 
		'next' => 'NeobuxUltimateStrategy',
		'publicListID' => '903f800e-6dda-4294-8cb5-dcdd17390e09' //id of next series - NeobuxUltimateStrategy
	)
);

foreach($elasticList as $name => $list) { 
	//get last day of newsletter series 
	$selN = 'SELECT MAX(day) as max FROM newsletters WHERE series="'.$name.'"';
	$resN = $db->query($selN); 
	
	foreach ( $resN as $n ) {
		
		$eeList[$name] = array(
			'max' => $n['max'],
			'next' => $list['next']
		); 
	}
}

//print_r($eeList); echo '<p>&nbsp;</p>';


//loop through each list  
foreach($eeList as $name => $list) { 
	//print_r($list); 
	$max = $list['max'];
	
	echo '(m='.$max.') '.$name.' ('.$list['next'].')'.$newline; 
	
	//get all contacts in EE list
	$class = 'contact';
	$action = 'GetContactsByList';
	$params = array(
		'listName' => $name
	);

	$result = ee_api_call($class, $action, $params);
	//print("<pre>".print_r($result, true)."</pre>"); 
	
	$contacts = $result->data;

	if(is_array($contacts))
		foreach($contacts as $contact) {
			$consent = $contact->dateadded; 
			$email = $contact->email;
			$dateadded = substr($consent, 0, 10);
			
			echo $email.' '.$dateadded.'  '; 
			
			//calculate # of days since added 
			$today = date('Y-m-d', time());
			$todayDT = new DateTime($today);
			$addedDT = new DateTime($dateadded);

			$newslDay = $addedDT->diff($todayDT)->format("%a");
			echo ' ('.$newslDay.') ';
			
			//compare newslDay to max day
			if($newslDay >= $max) {
				echo ' True';
				//delete sub from all lists 
				$params = array(
					'emails' => $email
				);
				$result = delete_contact($params); 
				
				//add sub to next list 
				$params = array(
					'email' => $subscriberEmail,
					'publiclistid' => $list['publicListID'], 
				);  
				$result = add_contact($params); 
				//print("<pre>".print_r($result,true)."</pre>");
				
				$insert = "INSERT INTO ee_transfer_subs (email, dateconsent, newsl_day, list_old, list_new) values (
					'".$subscriberEmail."', '".$dateadded."', '".$newslDay."', '".$name."', '".$list['next']."'
				)";

				$success = $db->query($insert);
				echo $success; 
			}
			else {
				echo ' False | ';
			}
			 
			echo $newline;
		}

	echo $newline;	
}

?>