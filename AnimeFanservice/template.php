<?
$dir = '../';
include($dir.'include/settings.php');

$imgDir = '';
$supportEmail = 'AnimeFavoriteChannel@gmail.com'; 
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
                            'series' => 'AnimeFanservice',
                            'folder' => 'AnimeFanservice'
                        );

                        if ($_GET['id']) {
							$query = "SELECT file FROM newsletters WHERE id='".$_GET['id']."'";
							$result = mysqli_query($conn, $query);
							$news = $result->fetch_assoc();
							
                            include($news['file']);
                        }
                        ?>  

						<p>Anime Empire<br />
						<a href="https://AnimeFanservice.org" target="_BLANK">AnimeFanservice.org</a><br />
                        <a href="mailto:<?=$supportEmail?>"><?=$supportEmail?></a>
                        </font></p>

                        <br />

                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</center>