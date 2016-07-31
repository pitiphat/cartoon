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
    <?php
	include("method/configDB.php"); //connect DB
        
        if(isset($_GET['edit'])){

                $sql = "select * from fine where Fine_Id='{$_GET['edit']}'";
                $result = mysqli_query($conn,$sql);
                $dataLoad = mysqli_fetch_array($result);
                
                if($dataLoad['Fine_Status']=="Open"){
                        $dataLoad['Fine_Status']="เปิดใช้งาน";
                    }
                    else if($dataLoad['Fine_Status']=="Close"){
                        $dataLoad['Fine_Status']="ปิดใช้งาน";
                    }
                        
	}
        // ------------ สถานะค่าปรับ ------------------
        $fStatus=array("เปิดใช้งาน", "ปิดใช้งาน");
		
            $htmlFineStatus = '<select name="fineStatus">';
            foreach($fStatus as $status_value){
                    if(isset($dataLoad) && $status_value ==$dataLoad['Fine_Status']){
                            $select = 'selected';
                    }
                    else{
                            $select = '';
                    }
                    $htmlFineStatus .= "<option value=\"$status_value\" $select>$status_value</option>";
            }
            $htmlFineStatus .= '</select>';
	//-------------------------------------------------	
	if(isset($_GET['delete'])){

                $sql = "UPDATE fine
			SET Fine_Status='Close'
			WHERE Fine_Id='{$_GET['delete']}'";
		$result = mysqli_query($conn,$sql);
                $_SESSION["massageEditbook"] = "success";
                header("location:manageFine.php?page=fine&subMenu=1");
                        
	}	
		
		
	if(isset($_GET['edit'])){ // ฟอร์มสำหรับแก้ไขค่าปรับ
		echo <<<HTMLBLOCK

          <form class="form-horizontal" name="form1" method="post" action="method/mEditFine.php">
          <div class="control-group">
            <label class="control-label" for="inputEmail">รหัสค่าปรับ</label>
            <div class="controls">
              <input name="fineId" type="text" value="{$dataLoad['Fine_Id']}"readonly/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputPassword">ราคาค่าปรับ <strong class="text-error" style="font-size: 20px">*</strong></label>
            <div class="controls">
              <input type="text" name="finePrice" value="{$dataLoad['Fine_Price']}" maxlength="2" required/> บาท
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputPassword">สถานะค่าปรับ <strong class="text-error" style="font-size: 20px">*</strong></label>
            <div class="controls">
              $htmlFineStatus
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <button type="submit" name="btnEditFine" class="btn btn-warning">แก้ไข</button>
            </div>
          </div>

        </form>
HTMLBLOCK;
	}
               
        else{ // แสดงหนังสือทั้งหมดที่แก้ไขได้
                $sql = "select * from fine
                        ORDER BY Fine_Price DESC";
                $result = mysqli_query($conn, $sql);
                echo"<p class='text-right'><a class='btn-small btn-primary' href='newFine.php?page=fine&subMenu=2'><i class='icon-plus-sign icon-white'></i>เพิ่ม</a></p>";
                $html = '<table class="table table-hover">'; 
                $html .= '<tr><th>รหัสค่าปรับ</th><th>ค่าปรับ</th><th>สถานะ</th><th></th></tr>';
                while($array=mysqli_fetch_array($result)){
                    if($array['Fine_Status']=="Open"){
                        $status="เปิดใช้งาน";
                    }
                    else if($array['Fine_Status']=="Close"){
                        $status="ปิดใช้งาน";
                    }
                    $html = $html ."<tr class='info'><td>{$array['Fine_Id']}</td>";
                    $html = $html ."<td>{$array['Fine_Price']}</td>";
                    $html = $html ."<td>$status</td>";
                    $html = $html ."<td><div class='btn-group'>
                                    <a class='btn btn-mini' href='manageFine.php?page=fine&subMenu=1&edit={$array['Fine_Id']}'><i class='icon-pencil'></i> แก้ไข</a>
                                    <a class='btn btn dropdown-toggle' data-toggle='dropdown' href='#'><span class='caret'></span></a>
                                    <ul class='dropdown-menu'>
                                      <li><a href='manageFine.php?page=fine&subMenu=1&edit={$array['Fine_Id']}'><i class='icon-pencil'></i> แก้ไข</a></li>
                                      <li><a href='manageFine.php?page=fine&subMenu=1&delete={$array['Fine_Id']}'><i class='icon-trash'></i> ปิดใช้งาน</a></li>
                                    </ul>
                                  </div>
                                  </td>";
                }
                    $html = $html . '</table>';
                    echo $html;
            }
	mysqli_close($conn);
        
?>
    </<div>
    </div>
</div>
</div>

</body>
</html>
