<?php
$dir = '../';
include($dir.'include/settings.php');

$X_img = '<img src="http://neobuxultimatestrategy.com/images/newsletter/X.jpg" width="22px">';
$newsletterImage = 'http://neobuxultimatestrategy.com/images/newsletter/';
$emailVar = '**SIG_EMAIL**'; 
$nameVar = '**NAME**';
?>
<center>
<table width="728px" border="0" cellspacing="0" cellpadding="0px">
    <tr>
        <td>
            <table cellpadding="20px">
                <tr>
                    <td>
                            
                        <font size="4">
                        <?
                        if ($_GET['id']) {
							$query = "SELECT file FROM newsletters WHERE id='".$_GET['id']."'";
							$result = mysqli_query($conn, $query);
							$news = $result->fetch_assoc();
							
                            include($news['file']);
                        }
                        ?> 

                        <p>&nbsp; </p>
                        Benjamin Louie<br />
                        Internet Marketer<br />
                        <a href="mailto:<?=$emailVar?>"><?=$emailVar?></a>
                        </font>

                        <br />

                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</center>