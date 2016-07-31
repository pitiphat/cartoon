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

                $sql = "select * from employee where Emp_Id='{$_GET['edit']}'";
                $result = mysqli_query($conn,$sql);
                $dataLoad = mysqli_fetch_array($result);
                
                if($dataLoad['Emp_Status']=="Open"){
                        $dataLoad['Emp_Status']="เปิดใช้งาน";
                }
                else if($dataLoad['Emp_Status']=="Close"){
                        $dataLoad['Emp_Status']="ปิดใช้งาน";
                }
                
                if($dataLoad['Gender']=="M"){
                        $dataLoad['Gender']="ชาย";
                }
                else if($dataLoad['Gender']=="F"){
                        $dataLoad['Gender']="หญิง";
                }
                
                if($dataLoad['Emp_Lv']=="1"){
                        $dataLoad['Emp_Lv']="พนักงาน";
                }
                else if($dataLoad['Emp_Lv']=="99"){
                        $dataLoad['Emp_Lv']="เจ้าของร้าน";
                }
                        
	}
        
        //---------- ตำแหน่งพนักงาน ----------------------------------------------------
		$eStatusStr=array("เจ้าของร้าน", "พนักงาน");
		
		$htmlEmpLV = '<select name="empLV">';
		foreach($eStatusStr as $status_value){
			if(isset($dataLoad) && $status_value ==$dataLoad['Emp_Lv']){
				$select = 'selected';
			}
			else{
				$select = '';
			}
			$htmlEmpLV .= "<option value=\"$status_value\" $select>$status_value</option>";
		}
		$htmlEmpLV .= '</select>';
		//-----------------------------------------------------------------------
		
		//---------- เพศ ---------------------------------------------------------
		$eStatusStr=array("ชาย", "หญิง");
		
		$htmlEmpGender = '<select name="empGender">';
		foreach($eStatusStr as $status_value){
			if(isset($dataLoad) && $status_value ==$dataLoad['Gender']){
				$select = 'selected';
			}
			else{
				$select = '';
			}
			$htmlEmpGender .= "<option value=\"$status_value\" $select>$status_value</option>";
		}
		$htmlEmpGender .= '</select>';
		//-----------------------------------------------------------------------
        
        // ------------ สถานะพนักงาน ------------------
        $fStatus=array("เปิดใช้งาน", "ปิดใช้งาน");
		
            $htmlEmpStatus = '<select name="empStatus">';
            foreach($fStatus as $status_value){
                    if(isset($dataLoad) && $status_value ==$dataLoad['Emp_Status']){
                            $select = 'selected';
                    }
                    else{
                            $select = '';
                    }
                    $htmlEmpStatus .= "<option value=\"$status_value\" $select>$status_value</option>";
            }
            $htmlEmpStatus .= '</select>';
	//-------------------------------------------------	
	if(isset($_GET['delete'])){

            $sql = "UPDATE employee
                    SET Emp_Status='Close'
                    WHERE Emp_Id='{$_GET['delete']}'";
            $result = mysqli_query($conn,$sql);
            $_SESSION["massageEditbook"] = "success";
            header("location:manageEmployee.php?page=employee&subMenu=1");
                        
	}	
		
		
	if(isset($_GET['edit'])){ // ฟอร์มสำหรับแก้ไขพนักงาน
		echo <<<HTMLBLOCK
             
 <form class="form-horizontal" name="form1" method="post" action="method/mEditEmployee.php">
        <div class="control-group">
          <label class="control-label" for="inputEmail">รหัสพนักงาน </label>
          <div class="controls">
            <input name="empId" type="text" maxlength="8" value="{$dataLoad['Emp_Id']}"readonly/>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">username <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <input name="empUser" type="text" maxlength="8" value="{$dataLoad['Emp_User']}" readonly/>
          </div>
        </div>
         <div class="control-group">
          <label class="control-label" for="inputPassword">password <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <input name="empPass" type="password" maxlength="8" value="{$dataLoad['Emp_Pass']}" required/>
          </div>
        </div>
         <div class="control-group">
          <label class="control-label" for="inputPassword">ชื่อ <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <input name="empName" type="text" maxlength="15" value="{$dataLoad['Emp_Name']}" required/>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">นามสกุล <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <input name="empLastname" type="text" maxlength="15" value="{$dataLoad['Emp_Lastname']}" required/>
          </div>
        </div>
            <div class="control-group">
          <label class="control-label" for="inputEmail">ตำแหน่ง <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            $htmlEmpLV
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">เพศ <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            $htmlEmpGender
          </div>
        </div>
         <div class="control-group">
          <label class="control-label" for="inputPassword">ที่อยู่ <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <textarea name="empAddress" rows="4" maxlength="100" required/>{$dataLoad['Address']}</textarea>
          </div>
        </div>
         <div class="control-group">
          <label class="control-label" for="inputPassword">เบอร์โทร <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <input name="empTel" type="text" maxlength="10" value="{$dataLoad['Tel']}" required/>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">สถานะ <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            $htmlEmpStatus
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <button type="submit" name="btnEditEmployee" class="btn btn-warning">บันทึก</button>
          </div>
        </div>
       </form>
HTMLBLOCK;
	}
               
        else{ // แสดงหนังสือทั้งหมดที่แก้ไขได้
                $sql = "select * from employee
                        ORDER BY Emp_Id DESC";
                $result = mysqli_query($conn, $sql);
                echo"<p class='text-right'><a class='btn-small btn-primary' href='newEmployee.php?page=employee&subMenu=2'><i class='icon-plus-sign icon-white'></i>เพิ่ม</a></p>";
                $html = '<table class="table table-hover">'; 
                $html .= '<tr><th>รหัสพนักงาน</th><th>ชื่อ</th><th>นามสกุล</th><th>เพศ</th><th>เบอร์โทร</th><th>สถานะ</th></tr>';
                while($array=mysqli_fetch_array($result)){
                    if($array['Emp_Status']=="Open"){
                        $status="เปิดใช้งาน";
                    }
                    else if($array['Emp_Status']=="Close"){
                        $status="ปิดใช้งาน";
                    }
                    if($array['Gender']=="M"){
                        $gen="ชาย";
                    }
                    else if($array['Gender']=="F"){
                        $gen="หญิง";
                    }
                    $html = $html ."<tr class='info'><td>{$array['Emp_Id']}</td>";
                    $html = $html ."<td>{$array['Emp_Name']}</td>";
                    $html = $html ."<td>{$array['Emp_Lastname']}</td>";
                    $html = $html ."<td>{$gen}</td>";
                    $html = $html ."<td>{$array['Tel']}</td>";
                    $html = $html ."<td>$status</td>";
                    $html = $html ."<td><div class='btn-group'>
                                    <a class='btn btn-mini' href='manageEmployee.php?page=employee&subMenu=1&edit={$array['Emp_Id']}'><i class='icon-pencil'></i> แก้ไข</a>
                                    <a class='btn btn dropdown-toggle' data-toggle='dropdown' href='#'><span class='caret'></span></a>
                                    <ul class='dropdown-menu'>
                                      <li><a href='manageEmployee.php?page=employee&subMenu=1&edit={$array['Emp_Id']}'><i class='icon-pencil'></i> แก้ไข</a></li>
                                      <li><a href='manageEmployee.php?page=employee&subMenu=1&delete={$array['Emp_Id']}'><i class='icon-trash'></i> ปิดใช้งาน</a></li>
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
