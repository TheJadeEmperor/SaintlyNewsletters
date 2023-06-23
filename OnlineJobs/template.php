<?php
$dir = '../';
include($dir.'include/settings.php');

$bpsLink = 'http://bestpayingsites.com/?action=get-cash-for-surveys';
$paidSocialLink = 'https://hop.clickbank.net/?affiliate=ironprice&vendor=socialpaid&pid=videojobquiz495';
$writingJobsLink = 'https://bestpayingsites.com/?action=real-translator-jobs';


$domain = 'https://ultimateneobuxstrategy.com/';
$newsletterImage = $domain.'images/newsletter/';
$X_img = '<img src="'.$newsletterImage.'X.jpg" width="22px">';

$imgDir = 'http://bestpayingsites.com/images/';
$supportEmail = '**SIG_EMAIL**'; 
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
                        <a href="mailto:<?=$supportEmail?>"><?=$supportEmail?></a>
                        </font>

                        <br />

                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</center>