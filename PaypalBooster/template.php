<?
$dir = '../';
include($dir.'include/settings.php');

$mainLink = $productLink = 'http://bestpayingsites.com/ppbooster';
$epsLink = 'http://bestpayingsites.com/';
$nameVar = '**NAME**';
?>
<center>
<table border="1" cellpadding="0" cellspacing="0" style="width: 700px">
<tbody>
<tr style="background-color: rgb(0, 0, 0);">
    <td align="left">
        <a href="<?=$mainLink?>" style="color: #fff; text-decoration: none;">
            <table width="100%" style="color: #fff; padding: 4px;">
                <tr> 
                    <td>
                        <p align="center"><font size="5">Boost Your Paypal Account</font></p>
                    </td>
                </tr>
            </table>
        </a>
    </td>
</tr>
<tr>
    <td colspan="2">
        <table border="0" cellpadding="10" cellspacing="1" style="width: 700px;">
            <tr>
                <td align="left">
                    <br />
                    <font size="4">
                    <?
                     $options = array(
                        'series' => 'paypalbooster',
                        'folder' => 'PaypalBooster'
                    );

                    if ($_GET['id']) {
                        $news = $db->get_row("SELECT file FROM newsletters WHERE id='".$_GET['id']."'");
                        include($news->file);
                    }

                    ?> 	

                    <p>&nbsp; </p>
                    Paypal Booster<br />
                    Profit with PTCs<br />
                    <a href="mailto:booster@bestpayingsites.com">booster@bestpayingsites.com</a><br />
                    </font>
                </td>
            </tr>
            <tr>
                <td bgcolor="#000;" style="padding: 2px 5px;">
                <b><a href="<?=$mainLink?>" style="color: #fff; text-decoration: none;">
                    <table width="100%">
                    <tbody>
                        <tr>
                            <td align="center" style="color: #fff;"><p>Paypal Booster Pro</p></td>
                        </tr>
                    </tbody>
                    </table>
                </a></b>
                </td>
            </tr>
        </table>
    </td>
</tr>
</tbody>
</table>
</center>