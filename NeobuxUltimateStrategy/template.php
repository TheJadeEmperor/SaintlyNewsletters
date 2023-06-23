<?php
$dir = '../';
include($dir.'include/settings.php');

$domain = 'https://ultimateneobuxstrategy.com/';
$productLink = $domain;
$msLink = $domain.'minisite';
$newsletterImage = $domain.'images/newsletter/';
$X_img = '<img src="'.$newsletterImage.'X.jpg" width="22px">';
$nameVar = '**NAME**';
?>
<center>
<table border="1" cellpadding="0" cellspacing="0" style="width: 700px">
<tbody>
    <tr style="background-color: rgb(0, 0, 0);">
		<td align="left">
			<table width="100%" style="color: #fff;"><tr> 
				<td width="468px">
				<a href="<?=$productLink?>">
					<img src="https://bestpayingsites.com/images/banners/ebook.jpg" /></a>
				</td>
				<td align="center">
					<font size="4"><b>PTC Newsletter</b></font>
				</td>
			</tr>
			</table>
		</td>
    </tr>
    <tr>
	<td colspan="2" align="center">
		<table border="0" cellpadding="10" cellspacing="1" style="width: 670px;">
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
					<a href="<?=$productLink?>"><?=$productLink?></a>
					</font>
                    </td>
				</tr>
				<tr>
                    <td bgcolor="#000;" style="padding: 2px 5px;">
                    <table width="700px">
                        <tbody>
                            <tr>
                                <td align="center" height="40px">
                                    <b><a href="<?=$productLink?>" style="color: #fff;">Neobux Ultimate Strategy E-Course</a></b>
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