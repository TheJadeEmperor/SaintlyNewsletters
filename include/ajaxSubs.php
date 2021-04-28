<?php
$dir = '../';
include($dir.'include/mysql.php');
include($dir.'include/config.php');

$id = $_REQUEST['id'];

foreach($_REQUEST as $request => $value) {
    $_REQUEST[$request] = mysql_real_escape_string($value);
}

switch($_GET['action']) {
    case 'update':
        $update = "UPDATE $subscribersTable SET 
			email='".$_REQUEST['email']."', 
            subscribed='".$_REQUEST['subscribed']."',
            origin='".$_REQUEST['origin']."'
            WHERE id='".$id."'";
        
		$success = $db->query($update);
        
        if($success === TRUE)
            echo 'Updated record '.$id;
        else 
            echo 'Failed to update record '.$id;
        break;
        
    case 'delete':
		$queryDelete = "DELETE from $subscribersTable WHERE id='".$id."'";
        $resD = $db->query($queryDelete);
        
        if($resD === TRUE) 
            echo 'Successfully deleted record '.$id;
        else
            echo 'Failed to delete record '.$id;
        break;
        
    case 'create':
        $queryInsert = "INSERT INTO $subscribersTable (email, subscribed, origin) VALUES (
            '".$_REQUEST['email']."', '".$_REQUEST['subscribed']."', '".$_REQUEST['origin']."'
        )";

		$resI = $db->query($queryInsert) or die($db->error);

		echo "Inserted Record ID: " . $db->insert_id;
        
    case 'read': 
    default:
		$querySelect = "SELECT * FROM $subscribersTable WHERE id='".$id."'";
		$resN = $db->query($querySelect) or die($db->error);
        $news = $resN->fetch_assoc();

        echo json_encode($news);
        break;
}


?>