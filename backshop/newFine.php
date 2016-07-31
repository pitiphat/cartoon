<?php

    session_start(); 
                

        
        
if(!isset($_SESSION['UserID'])){
        header("location:login.php");
        exit();	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery-2.1.3.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
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
if($_SESSION["UserLV"]!="99"){
           echo '<div class="alert alert-error">
               คุณไม่มีสิทธิใช้งานเมนูนี้
            </div>';
           exit();
    }
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
            
            echo'<div class="alert alert-error">';
            echo '<button type="button" class="close" data-dismiss="alert"> &times </button>';
            
            foreach($_SESSION['massageEditbook'] as $e){
               echo "$e <br>";
                
            }
            
            echo '</div>';
            unset($_SESSION["massageEditbook"]);
        }
    }
?>
            
<?php
	include("method/configDB.php"); //connect DB
		$sql = 'select max(Fine_Id)+1 as newFineId from Fine';
		$result = mysqli_query($conn,$sql); 
		$load_Id = mysqli_fetch_array($result);
		
		if($load_Id['newFineId']==null){ 
			$newFineId = '001'; 
		}
		else{ 
			$newFineId = sprintf('%03s',$load_Id['newFineId']); 
		}
		// ---------  fine status
		$FStatus=array("Close", "Open");
		
		$htmlFineStatus = '<select name="fineStatus">';
		foreach($FStatus as $status_value){
			if(isset($dataLoad) && $status_value ==$dataLoad['Fine_Status']){
				$select = 'selected';
			}
			else{
				$select = '';
			}
			$htmlFineStatus .= "<option value=\"$status_value\" $select>$status_value</option>";
		}
		$htmlFineStatus .= '</select>';
?>

<form class="form-horizontal" name="form1" method="post" action="method/mNewFine.php">
  <div class="control-group">
    <label class="control-label" for="inputEmail">รหัสค่าปรับ</label>
    <div class="controls">
      <input name="fineId" type="text" value="<?php echo $newFineId;?>"readonly/>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">ราคาค่าปรับ <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
      <input type="text" name="finePrice" maxlength="2" required/> บาท
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <button type="submit" name="btnNewFine" class="btn btn-warning">ยืนยัน</button>
    </div>
  </div>
    
</form>
            </<div>
    </div>
</div>
</div>
</body>
</html>
