<?php
include($dir.'include/settings.php');


function update_html_code ($series) {
	global $db;

	//go through each newsletter in series
	$resN = $db->query("SELECT * FROM newsletters WHERE series='".$series."' ORDER BY day, subject asc");

	$count = 0;
	while($n = $resN->fetch_assoc()) {
		$id = $n['id']; 
		$day = $n['day'];
		 
		$fileName = 'http://localhost/SaintlyNewsletters/'.$series.'/template.php?id='.$id;
		$html_code = file_get_contents($fileName);
		
		//$html_code = parse_variables_html($html_code); 

		//if($count==2) echo $html_code;
		
		$updateQ = "UPDATE newsletters SET html_code='".addslashes($html_code)."' WHERE id='".$id."'";
	
		$updateN = $db->query( $updateQ ); 	
		
		if($updateN == 1) {
			echo 'Updated record '.$id.' | '.$series.' | '.$day.' | 
			<a href="?id='.$id.'" target="_BLANK">view</a><br />';
		}
 
		$count++;
	}
}


if($_GET['id']) { //view html for one newsletter
	
	$resN = $db->query("SELECT * FROM newsletters WHERE id='".$_GET['id']."'");
	
	while($n = $resN->fetch_assoc()) {
		echo $n['html_code'];
	}
	
	exit;
}

set_time_limit(0);


$seriesList = array( 'AnimeFanservice', //'BlackCrimesMatter', //'AllSubscribers', 
//'NeobuxUltimateStrategy', 'PTCPrograms', 'MakeMoneySurveys', 'OnlineJobs','PaypalBooster'
);

 
foreach($seriesList as $series) {

	update_html_code ($series);
	
}

?>