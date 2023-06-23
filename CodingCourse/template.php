<?
$dir = '../';
include($dir.'include/settings.php');

$imgDir = '';
$supportEmail = 'AnimeFavoriteChannel@gmail.com'; 
$nameVar = 'Anime Fan';
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
                            'series' => 'CodingCourse',
                            'folder' => 'CodingCourse'
                        );

                        if ($_GET['id']) {
							$query = "SELECT file FROM newsletters WHERE id='".$_GET['id']."'";
							$result = mysqli_query($conn, $query);
							$news = $result->fetch_assoc();
							
                            include($news['file']);
                        }
                        ?>  

						
<p>&nbsp;</p>

<p>Benjamin Louie<br />
    Ninja Coder<br />
    Full Stack Web Developer</p>

                        <br />

                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</center>