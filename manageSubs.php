<?
$dir = 'include/';
include($dir.'mysql.php'); 
include($dir.'config.php');

function subTable($series, $subRows) {
    
    $subTable = '<table cellpadding="0" cellspacing="0" border="0" class="display" id="'.$series.'">
    <thead>
        <tr>
            <th>#</th>
            <th>Email Address</th>
            <th>Subscribed</th>
            <th>Origin</th>
        </tr>
    </thead>
    <tfoot>
    </tfoot>
    <tbody>
         '.$subRows.'
    </tbody>
</table>';

    return $subTable;
}

//loop through all contacts by series 
$selS = 'SELECT * FROM '.$subscribersTable.' ORDER BY series asc';
$resS = $db->query($selS);

$count = 0;
while($sub = $resS->fetch_assoc()) {

	$emailTo = $sub['email'].' '; 
	$subscribed = $sub['subscribed'];
	$series = $sub['series'];
    $origin = $sub['origin'];

    $subArray[$series][$count] = array(
        'emailTo' => $emailTo,
        'subscribed' => $subscribed,
	    'series' => $series,
        'origin' => $origin
    );

    $subRows[$series] .= '<tr><td>'.$count.'</td><td>'.$emailTo.'</td><td>'.$subscribed.'</td><td>'.$origin.'</td>
    </tr>';

    $count++;
}

print("<pre>".print_r( $subArray, true)."</pre>"); 


//make pop up form for updating sub



$srcDir = 'include/';
$bootDir = 'include/bootstrap/'
?>

    <link href="include/css/admin.css" rel="stylesheet" />

    <!-- dataTable styles -->
    <style type="text/css" media="screen">
        @import "<?= $srcDir ?>media/css/demo_table.css";
        @import "<?= $srcDir ?>media/css/demo_table_jui.css";
        @import "<?= $srcDir ?>media/css/themes/base/jquery-ui.css";
        @import "<?= $srcDir ?>media/css/themes/smoothness/jquery-ui-1.7.2.custom.css";

        .dataTables_info { padding-top: 0; }
        .dataTables_paginate { padding-top: 0; }
        .css_right { float: right; }
        #example_wrapper .fg-toolbar { font-size: 0.8em }
        #theme_links span { float: left; padding: 2px 10px; }
    </style>
    <link href="<?= $bootDir ?>css/bootstrap-theme.css" rel="stylesheet" />
    <link href="<?= $bootDir ?>css/bootstrap.css" rel="stylesheet" />

    <!--jquery scripts-->
    <script src="<?= $srcDir ?>media/js/complete.js"></script>
     <script src="<?= $srcDir ?>media/js/jquery.min.js" type="text/javascript"></script>
     <script src="<?= $srcDir ?>media/js/jquery-ui.js" type="text/javascript"></script>
     <script src="<?= $srcDir ?>media/js/jquery.validate.js" type="text/javascript"></script>
     
     <script src="<?= $bootDir ?>js/bootstrap.min.js"></script><!--bootstrap scripts-->
     <script src="<?= $srcDir ?>media/js/jquery.dataTables.min.js" type="text/javascript"></script> <!--dataTable scripts-->

<script> 
$(document).ready( function () {
    $('#AnimeFanservice').dataTable({  
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "iDisplayLength": 50
    });

    $('#BlackCrimesMatter').dataTable({  
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "iDisplayLength": 50
    });

    $('#NeobuxUltimateStrategy').dataTable({  
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "iDisplayLength": 50
    });

    $('#makemoneysurveys').dataTable({  
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "iDisplayLength": 50
    });
})
</script>


<?

echo '<h2>AnimeFanservice</h2>';
echo subTable('AnimeFanservice', $subRows['AnimeFanservice']);

echo '<h2>BlackCrimesMatter</h2>';
echo subTable('BlackCrimesMatter', $subRows['BlackCrimesMatter']);

echo '<h2>NeobuxUltimateStrategy</h2>';
echo subTable('NeobuxUltimateStrategy', $subRows['NeobuxUltimateStrategy']);

echo '<h2>MakeMoneySurveys</h2>';
echo subTable('makemoneysurveys', $subRows['makemoneysurveys']);

?>