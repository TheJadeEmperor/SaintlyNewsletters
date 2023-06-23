<?php
$dir = '../';
$read_call = $dir.'include/ajax.php?action=read';
$update_call = $dir.'include/ajax.php?action=update';
$create_call = $dir.'include/ajax.php?action=create';
$delete_call = $dir.'include/ajax.php?action=delete';
?>
<html>
<head>
    <link href="<?=$dir?>include/buttons.css" rel="stylesheet" type="text/css" media="screen" />    

    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css" />
  
    <style>
    .subject {
        position: relative;
        padding: 10px;
    }
    
    .the-buttons {
        top:0;
        left:0; 
    }
    
    .container {
        position: relative;
        width: 700px;
        border: 1px solid black;
        text-align: left;
        margin: 0 auto;
        padding: 10px 5px;
    }
    
    #updateForm {
        display: none;
    }
    
    #updateForm * {
        font-size: medium;
    }
    
    .createButtonTop {
        position: absolute;
        top: 0px; 
        right: 0px;
    }
    
    .createButtonBottom {
        position: absolute;
        bottom: 0px;
        right: 0px;
    }
    </style>

    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>

    <script>
    jQuery(function() {    
        jQuery('.the-buttons').hide();
        jQuery('.subject').hover(function() {
            jQuery(this).find('.the-buttons').fadeIn(10);
        }, function() {
            jQuery(this).find('.the-buttons').fadeOut(10); 
        });
    });

    function updateRow(id) {
           $.ajax({ //Process the form using $.ajax()
               type        : 'POST', //Method type
               url         : '<?=$update_call?>', //Your form processing file url
               data        : $('#updateForm').serialize(), 
               success     : function(msg) {
                    //alert('server side msg: '+msg)
                    location.reload();
                }
           });
           event.preventDefault(); //Prevent the default submit      
    }
    
    function fillForm(id) {
        console.log("<?=$read_call?>&id="+id);
        $.getJSON("<?=$read_call?>&id="+id, function( data ) {
            console.log("<?=$read_call?>&id="+id);
            $.each( data, function( key, val ) {
                if(data.hasOwnProperty(key))
                    $('input[name='+key+']').val(val);

                if(key == 'file') {
                    $('select[name="file"]').find('option:contains("'+val+'")').attr("selected",true);
                }
            });
        });
    }
    
    function deleteRow(id) {
        if (confirm("Are you sure you want to delete record "+id+"?")) {
            $.ajax({
                type: "GET",
                url: "<?=$delete_call?>&id="+id,
                success: function() {
                    alert('Deleted record '+id);
                    location.reload();
                }
            })
        }    
    }
    
    function createRow() {
        $.ajax({
            type: "POST",
            url: "<?=$create_call?>",
            data: $('#updateForm').serialize(),
            success: function(msg) {
                //alert('server msg: '+msg);
                location.reload();
            }
        });
    }
    
    function copyValue() {
        var file = $("#file").val();
        var subject = file.substring(5 ,file.length - 5);
        $("#subject").val(subject);
    }
 
    $(document).ready(function () {
        $(".updateButton").click(function () {
            $("#updateForm").dialog({
                modal: true,
                width: 700,
                position: 'top',
                show: {
                    effect: "explode",
                    duration: 500
                },
                hide: {
                    effect: "explode",
                    duration: 500
                },
                buttons: {
                    Save: function () {
                        var id = $('#id').val();
                        updateRow(id);
                        $( this ).dialog( "close" );
                    },
                    Cancel: function() {
                        $( this ).dialog( "close" );
                    },                        
                }
            });
        });
        
        $(".createButton").click(function() {
            $("#updateForm").dialog({
                modal: true,
                width: 700,
                position: 'top',
                show: {
                    effect: "explode",
                    duration: 500
                },
                hide: {
                    effect: "explode",
                    duration: 500
                },
                buttons: {
                    Save: function() {
                        createRow();
                        $(this).dialog("close");
                    },
                    Cancel: function() {
                        $(this).dialog("close");
                    }
                }
            })
        });
    });
    
    </script>
</head>
<body>
    <div class="container">
    <?php
        $series = $options['series'];
        $folder = $options['folder'];

        $exclude = array('Thumbs.db', 'index.php', 'template.php', '.', '..', '(backup)');
        if($handle = opendir('./')) {        
            while (false !== ($file = readdir($handle))) {  //List all the files
            
                if(!in_array($file, $exclude)) {				
                    $dropDownMenu .= '<option>'.$file.'</option>';
                }
            }
        }

		$queryN = "SELECT * FROM newsletters WHERE series='".$series."' ORDER BY day, subject asc";
		
        $resN = $db->query($queryN) or die($db->error);

		$num = 0;
		while($n = $resN->fetch_assoc()){
			$day = $n['day'];

            $subject = $n['subject'];
            $product = $n['product'];
            $id = $n['id'];
            
            if(empty($product) || $product == 'none') 
                $product = 'none';
            else
                $product = '<b>'.$product.'</b>';
            
            $newsletterDir = 'http://localhost/SaintlyNewsletters/';
            
			$deleteBtn = '<input type="button" class="btn btn-danger" value=" Delete ('.$day.')" onclick="deleteRow(\''.$id.'\')" />';
			
			$updateBtn = '<input type="button" class="btn btn-success updateButton" value=" Update ('.$day.') " onclick="fillForm(\''.$id.'\')" />';
			
            $newsletterContent .= '<div id="'.$id.'" class="subject">'.$day.' - '.$product.' | <span id="subject'.$id.'" contentEditable="true" onclick="document.execCommand(\'selectAll\',false,null)"><a href="?id='.$id.'">'.$subject.'</a></span> |
                 <a href="template.php?id='.$id.'" target="_blank">View</a><br />
                <span class="the-buttons">
                    '.$deleteBtn.'
					'.$updateBtn.'
                    
                    <a href="template.php?id='.$id.'" target="_BLANK"><input type="button" class="btn" value=" View " ></a>
                </span>
            </div>';

            $num++;
        }

        $newsletterContent = $editSubjectLine.' '.$newsletterContent.' '.$editSubjectLine;

        echo $newsletterContent;    
    ?>
    <div class="createButtonTop">
        <input type="button" class="btn btn-sucess createButton" value="Create Newsletter" />
    </div>
    <div class="createButtonBottom">
        <input type="button" class="btn btn-sucess createButton" value="Create Newsletter" />
    </div>
        
    </div>
    <p>&nbsp;</p>
    
    
<form id="updateForm" title="Update Subject Line">
    <br />
    <input type="hidden" name="id" id="id" />
    <input type="hidden" name="series" id="series" value="<?=$options['series']?>" />
    <table>
        <tr>
            <td colspan="2">
                 <span>ID: </span><input type="button" name="id" />
            </td>
        </tr>
        <tr>
            <td><span>Day</span></td>
            <td><span>Subject</span></td>
        </tr>
        <tr>
            <td><input type="text" name="day" id="day" size="2" maxlength="2" /></td>
            <td><input type="text" name="subject" id="subject" size="50" maxlength="70"/>
                <input type="button" value=" Copy " onclick="copyValue();"/>
            </td>
        </tr>
        <tr>
            <td colspan="2"><span>Linked File<br />
            <select id="file" name="file"><?=$dropDownMenu?></select></span></td>
        </tr>
        <tr>
            <td colspan="">Product<br /><input type="text" name="product" id="product" size="10"/> </td>
			<td colspan="">Series<br /><input type="text" name="series" id="series" size="20"/> </td>
        </tr>
    </table>
    <br />
</form>