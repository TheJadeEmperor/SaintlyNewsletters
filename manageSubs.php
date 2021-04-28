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

    $id = $sub['id'];
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

    $subRows[$series] .= '<tr><td><a href="javascript:updateSaleDialog(\''.$id.'\')">'.$count.'</a></td><td><a href="javascript:updateSaleDialog(\''.$id.'\')">'.$emailTo.'</a></td><td>'.$subscribed.'</td><td>'.$origin.'</td>
    </tr>';

    $count++;
}

// print("<pre>".print_r( $subArray, true)."</pre>"); 


$srcDir = 'include/';
$bootDir = 'include/bootstrap/';
$ajaxCreate = $srcDir.'ajaxSubs.php?action=create';
$ajaxRead = $srcDir.'ajaxSubs.php?action=read';
$ajaxUpdate = $srcDir.'ajaxSubs.php?action=update';
$ajaxDelete = $srcDir.'ajaxSubs.php?action=delete';
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
    //declare dataTables for newslsetter series
    var tableAF = $('#AnimeFanservice').dataTable({  
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

}); //document.ready

    function updateSaleDialog (salesID) {
        $('#saveButton').attr('disabled', true);
        fillSalesForm(salesID); //fill in the form fields from database

        $('#addSaleForm').dialog({
            modal: true,
            width: 450,
            position: 'center',
            show: {
                effect: "explode",
                duration: 500
            },
            hide: {
                effect: "explode",
                duration: 500
            },
            beforeClose: function( event, ui ) {
                $('#saveButton').attr('disabled', false);
                $('#updateButton').attr('disabled', false);
                $("input[type=text]").val("");
                $("input[id=id]").val("");
            }
        });
    }
    
    function insertSale () {
        if ($('#addSaleForm').valid()) {
            $.ajax({
                type: "POST",
                url: "<?=$ajaxCreate?>",
                data: $('#addSaleForm').serialize(),
                success: function(msg) {
                    alert('Message: '+msg);
                    location.reload();
                    //custTable.ajax.reload( null, false );
                }
            });
            closeDialog();
        }
    }

function updateSaleDB () {
    var id = $('#id').val();
    if ($('#addSaleForm').valid()) {
        $.ajax({
            type: "POST",
            url: "<?=$ajaxUpdate?>",
            data: $('#addSaleForm').serialize()+'&id='+id,
            success: function(msg) {
                //alert('Message: '+msg);
                //////////////////////////////////////////////////////
                tableAF.ajax.reload(); //decide which table to reload
                //////////////////////////////////////////////////////
            }
        });
    }
    closeDialog();
}

function fillSalesForm (salesID) {
	console.log('salesID '+salesID);
	$.ajax({ 
		type        : 'POST',
		url         : '<?=$ajaxRead?>', 
		data        : 'id='+salesID,
		success     : function(data) {
			data = $.parseJSON(data);
			console.log('data '+data);
			$.each(data, function(name, value) {
				//console.log(name+' '+value);
				
				if(name == 'id') $('#sale_id').val(value);
				
				$('#'+name).val(value);
			});          
		}
	});
}

function closeDialog () {
   $('button').attr('disabled', false); //enable all buttons
   $('#addSaleForm').dialog("close"); //close the dialog
   //clear the sales form
   $("input[type=text]").val("");
   $("#addSaleForm")[0].reset();
}

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

$salesFields = array(
    'email' => array(
        'id' => 'email',
        'size' => '30',
        'maxsize' => '50'
    ),
    'origin' => array(
        'id' => 'origin',
        'size' => '30',
        'maxsize' => '50'
    ),
    'subscribed' => array(
        'id' => 'subscribed',
        'maxsize' => '20'
    ),

);

?>

<form id="addSaleForm" title="Update Subscriber">
    <div style="padding: 10px;">
        <table>
            <tr>
                <td align="right">ID</td>
                <td width="5px"></td>
                <td align="left"><input type="button" id="sale_id" /><input type="hidden" id="id" /></td>
            </tr>
            <?
            foreach($salesFields as $disp => $textBox) {
                echo '<tr title="'.$textBox['id'].'">
                    <td align="right" width="120px">'.$disp.'</td><td></td>
                    <td align="left"><input type="text" class="activeField" name="'.$textBox['id'].'" id="'.$textBox['id'].'" size="'.$textBox['size'].'" /></td>
                </tr>';
            }
            ?>
        </table>
    </div>
    <br />
    <center>
        <input type="button" class="btn btn-success" id="saveButton" value="Save" onclick="insertSale()" />
        <input type="button" class="btn btn-info" id="updateButton" value="Update" onclick="updateSaleDB()" />
        <input type="button" class="btn btn-warning" id="cancelButton" value="Cancel" onclick="closeDialog()" />
    </center>
   
</form>