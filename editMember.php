<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

    session_start();               

        
?>
<title>Untitled Document</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>


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
if(isset($_SESSION['massageFrontShop']))
    {  
        if($_SESSION['massageFrontShop'] == "success")
        {echo'   <div class="alert alert-success">';
            echo '<button type="button" class="close" data-dismiss="alert"> &times </button>';
            echo "{$_SESSION['massageFrontShop']}";
            echo '</div>';
            unset($_SESSION["massageFrontShop"]);
        }
        else{
            
            echo'   <div class="alert alert-error">';
            echo '<button type="button" class="close" data-dismiss="alert"> &times </button>';
            
            foreach($_SESSION['massageFrontShop'] as $e){
               echo "$e <br>";
                
            }
            
            echo '</div>';
            unset($_SESSION["massageFrontShop"]);
        }
    }


if(isset($_SESSION['MemberUserID'])){
	include("backshop/method/configDB.php");
	
	$sql = "select * from member where Mem_Id='{$_SESSION['MemberUserID']}'";
	$result = mysqli_query($conn,$sql);
	$dataLoad = mysqli_fetch_array($result);
        if($dataLoad['Gender'] == "M"){
            $gender="ชาย";
        }
        else{
            $gender="หญิง";
        }
        
        $eStatusStr=array("ชาย", "หญิง"); //โค๊ตสถานะสมาชิก
		
		$htmlMemStatus = '<select name="memGender">';
		foreach($eStatusStr as $status_value){
			if(isset($dataLoad) && $status_value == $gender){
				$select = 'selected';
			}
			else{
				$select = '';
			}
			$htmlMemStatus .= "<option value=\"{$status_value}\" $select>{$status_value}</option>";
		}
		$htmlMemStatus .= '</select>';
        
        echo <<<HTMLBLOCK
             
 <form class="form-horizontal" name="form1" method="post" action="editMember2.php">
        <div class="control-group">
          <label class="control-label">รหัสสมาชิก</label>
          <div class="controls">
            <input name="MemberUserID" type="text" maxlength="8" value="{$dataLoad['Mem_Id']}"readonly/>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">รหัสบัตรประชาชน <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <input name="idCard" type="text" maxlength="13" value="{$dataLoad['Id_Card']}" required/>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">เพศ <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            $htmlMemStatus
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">username</label>
          <div class="controls">
            <input name="memUser" type="text" maxlength="8" value="{$dataLoad['Mem_User']}" readonly/>
          </div>
        </div>
         <div class="control-group">
          <label class="control-label">password <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <input name="memPass" type="password" maxlength="8" value="{$dataLoad['Mem_Pass']}"/>
          </div>
        </div>
         <div class="control-group">
          <label class="control-label">ชื่อ <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <input name="memName" type="text" maxlength="15" value="{$dataLoad['Mem_Name']}"/>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">นามสกุล <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <input name="memLastname" type="text" maxlength="15" value="{$dataLoad['Mem_Lastname']}"/>
          </div>
        </div>
        
         <div class="control-group">
          <label class="control-label">ที่อยู่ <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <textarea name="memAddress" rows="4" maxlength="100"/>{$dataLoad['Address']}</textarea>
          </div>
        </div>
         <div class="control-group">
          <label class="control-label">เบอร์โทร <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <input name="memTel" type="text" maxlength="10" value="{$dataLoad['Tel']}"/>
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <button type="submit" name="btnEditMember" class="btn btn-warning">บันทึก</button>
          </div>
        </div>
       </form>
HTMLBLOCK;

}
else{
	echo '
	<div class="alert alert-error">
		คุณยังไม่ได้เข้าสู่ระบบ

	</div>';
}
?>
    		
    
    </<div>
    </div>
</div>
</div>

</body>
</html>
