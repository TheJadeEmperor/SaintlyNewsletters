<?
$dir = '../';
include($dir.'include/settings.php');

$X_img = '<img src="http://neobuxultimatestrategy.com/images/newsletter/X.jpg" width="22px">';
$newsletterImage = 'http://neobuxultimatestrategy.com/images/newsletter/';
$productLink = 'http://neobuxultimatestrategy.com/';
$msLink = 'http://neobuxultimatestrategy.com/minisite';
$refURL = 'http://neobuxultimatestrategy.com/images/refs/';


$outsideLink = 'http://www.clixsense.com/en/My_Account';
$csLink = 'http://www.clixsense.com/?3373459&newsletter';
$nameVar = '**NAME**';
?>
<center>
<table border="1" cellpadding="0" cellspacing="0" style="width: 700px">
<tbody>
    <tr style="background-color: #000;">
	<td align="left">
		<table width="100%">
			<tr>
			<td width="468px">
				<a href="<?=$productLink?>"><img src="http://bestpayingsites.com/images/banners/nus1.jpg" /></a>
			</td>
			<td align="center">
				<font size="4"><b><a href="http://neobuxultimatestrategy.com" style="color: #fff; text-decoration: none;">PTC Crash Course</a></b></font>
			</td>
			</tr>
		</table>
	</td>
    </tr>
    <tr>
	<td colspan="2" align="center">
            <table border="0" cellpadding="10" cellspacing="1" style="width: 680px;">
		<tbody>
                    <tr>
			<td align="left">
			<br />
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
            Benjamin Louie <br />
			Neobux Ultimate Strategy<br />
			<a href="http://neobuxultimatestrategy.com">http://neobuxultimatestrategy.com</a>
			</font>
                    </td>
		</tr>
		<tr>
                    <td bgcolor="#000;" style="padding: 2px 5px;">
                    <table width="700px">
                        <tbody>
                            <tr>
                                <td align="center" height="40px">
                                    <b><a href="http://neobuxultimatestrategy.com" style="color: #fff;">PTC Crash Course</a></b>
                                </td>       
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
        </table>
    </td>
</tr>
</tbody>
</table>
</center>