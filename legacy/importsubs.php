<?php
$dir = '../include/';
include($dir.'class.phpmailer.php');
include($dir.'class.smtp.php');
include($dir.'mysql.php'); 
include($dir.'config.php');

set_time_limit(0);

$row = 1;
if (($handle = fopen("allsubs.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        
        for ($c=0; $c < $num; $c++) {
            $email = $data[$c];

            if($c == 0 && $email) {
                echo $email . "<br /> \n";

                $insertSQL = 'INSERT INTO newsl_subscribers (email, series) VALUES ("'.$email.'", "AllSubscribers")'; 
                // $success = $db->query($insertSQL); 

                // echo $insertSQL.'<br />';
                if($success == 1) 
                    echo ' 1 ';
                else
                    echo ' 0: '.mysqli_error();
            }
        }
        $row++;
    }
    fclose($handle);
}


?>