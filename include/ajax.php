<?php
$dir = '../';
include($dir.'include/mysql.php');
include($dir.'include/config.php');

$id = $_REQUEST['id'];

foreach($_REQUEST as $request => $value) {
    $_REQUEST[$request] = mysqli_real_escape_string($db, $value);
}

switch($_GET['action']) {
    case 'update':
        $update = "UPDATE newsletters SET 
			day='".$_REQUEST['day']."', 
            subject='".$_REQUEST['subject']."',
            file='".$_REQUEST['file']."',
            product='".$_REQUEST['product']."',
			series='".$_REQUEST['series']."'
            WHERE id='".$id."'";
        
		$success = $db->query($update);
        
        if($success === TRUE)
            echo 'Updated record '.$id;
        else 
            echo 'Failed to update record '.$id;
        break;
        
    case 'delete':
		$queryDelete = "DELETE from newsletters WHERE id='".$id."'";
        $resD = $db->query($queryDelete);
        
        if($resD === TRUE) 
            echo 'Successfully deleted record '.$id;
        else
            echo 'Failed to delete record '.$id;
        break;
        
    case 'create':
        $queryInsert = "INSERT INTO `newsletters` (day, subject, file, series, product) VALUES (
            '".$_REQUEST['day']."', '".$_REQUEST['subject']."', '".$_REQUEST['file']."', '".$_REQUEST['series']."',
            '".$_REQUEST['product']."'
        )";

		$resI = $db->query($queryInsert) or die($db->error);

		echo "Inserted Record ID: " . $db->insert_id;
        
    case 'read':
    default:
	    $querySelect = "SELECT * FROM newsletters WHERE id='".$id."'";
		$resN = $db->query($querySelect) or die($db->error);
        $news = $resN->fetch_assoc();

        echo json_encode($news);
        break;
}


?>