<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
 
    session_start();               
        
        
if(!isset($_SESSION['UserID'])){
    header("location:login.php");
    exit();	
}
?>
<title>Untitled Document</title>
<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery-2.1.3.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script language="javascript">
$(document).ready(function(){
    var next = 1;
    $(".add-more").click(function(e){
		
		
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;
        var newIn = '<input autocomplete="off" class="input form-control" id="field' + next + '" name="field[]" type="text" maxlength="8" required/>';
        var newInput = $(newIn);
        var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >-</button></div><div id="field">';
        var removeButton = $(removeBtn);
        $(addto).after(newInput);
        $(addRemove).after(removeButton);
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);  
        
            $('.remove-me').click(function(e){
                e.preventDefault();
                var fieldNum = this.id.substr(this.id.lastIndexOf("e")+1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
            });
		
    });
       
});
</script>

</head>

<body>

<div class="container">   
<?php
include 'header.php';
include 'menu.php';

?>
 <div class="span9">
        <div class="well">
			
    		<?php
    if(isset($_SESSION['massageEditbook']))
    {  
        if($_SESSION['massageEditbook'] == "success")
            {echo'   <div class="alert alert-success">';
            echo '<button type="button" class="close" data-dismiss="alert"> &times </button>';
            echo "{$_SESSION['massageEditbook']}";
            echo '</div>';
            unset($_SESSION["massageEditbook"]);
        }
        else{
            
            echo'   <div class="alert alert-error">';
            echo '<button type="button" class="close" data-dismiss="alert"> &times </button>';
            
            foreach($_SESSION['massageEditbook'] as $e){
               echo "$e <br>";
                
            }
            
            echo '</div>';
            unset($_SESSION["massageEditbook"]);
        }
    }
?>

    <form class="form-horizontal" action="method/returnCheck.php" method="POST">
        <div class="control-group">
          <label class="control-label">รหัสหนังสือ <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
                <div id="field">
                      <input autocomplete="off" class="input" id="field1" name="field[]" type="text"
                  data-items="8" maxlength="8" required/><button id="b1"class="btn add-more" type="button">+</button>
                </div>
          </div>
        </div>

        <div class="control-group">
          <div class="controls">
            <button type="submit" name="btnCheckReturn" class="btn btn-warning">ตรวจสอบ</button>
          </div>
        </div>
    </form>
    
    </<div>
    </div>
</div>
</div>

</body>
</html>
