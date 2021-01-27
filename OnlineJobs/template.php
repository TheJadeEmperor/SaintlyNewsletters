<?
$dir = '../';
include($dir.'include/settings.php');

$productLink = 'http://bestpayingsites.com/?action=get-cash-for-surveys';
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
                        $options = array(
                            'series' => 'makemoneysurveys',
                            'folder' => 'MakeMoneySurveys'
                        );

                        if ($_GET['id']) {
                            $news = $db->get_row("SELECT file FROM newsletters WHERE id='".$_GET['id']."'");
                            include($news->file);
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