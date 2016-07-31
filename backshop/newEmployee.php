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
		$sql = 'select max(Emp_Id)+1 as nextEmpId from employee';
		$result = mysqli_query($conn,$sql); 
		$load_Id = mysqli_fetch_array($result);
		
		if($load_Id['nextEmpId']==null){ 
			$newEmpId = '00000001'; 
		}
		else{ 
			$newEmpId = sprintf('%08s',$load_Id['nextEmpId']); 
		}
?>


    <form class="form-horizontal" name="form1" method="post" action="method/mNewEmployee.php">
        <div class="control-group">
          <label class="control-label" for="inputEmail">รหัสพนักงาน</label>
          <div class="controls">
            <input name="empId" type="text" value="<?php echo $newEmpId;?>"readonly/>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">username <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <input type="text" name="empUser" maxlength="8" value=""placeholder="ใส่ชื่อที่ใช้งานในระบบ" required/>
          </div>
        </div>
         <div class="control-group">
          <label class="control-label" for="inputPassword">password <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <td><input type="Password" name="empPass" maxlength="8"placeholder="ใส่รหัสผ่าน" required/>
          </div>
        </div>
         <div class="control-group">
          <label class="control-label" for="inputPassword">ชื่อ <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <input type="text" name="empName" maxlength="15" required/>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">นามสกุล <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <input type="text" name="empLastname" maxlength="15" required/>
          </div>
        </div>
            <div class="control-group">
          <label class="control-label" for="inputEmail">ตำแหน่ง <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
              <select name="LV">
                <option value="1" selected>พนักงาน</option>
                <option value="99">เจ้าของร้าน</option>
              </select>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">เพศ <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
              <select name="gender">
                <option value="M">ชาย</option>
                <option value="F">หญิง</option>
              </select>
          </div>
        </div>
         <div class="control-group">
          <label class="control-label" for="inputPassword">ที่อยู่ <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <textarea name="address" rows="4" maxlength="100" placeholder="ที่อยู่ปัจจุบัน" required/></textarea>
          </div>
        </div>
         <div class="control-group">
          <label class="control-label" for="inputPassword">เบอร์โทร <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <input type="text" name="Tel" maxlength="10" required/>
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <button type="submit" name="btnNewEmployee" class="btn btn-warning">บันทึก</button>
          </div>
        </div>
    </form>
    
    
    </<div>
    </div>
</div>
</div>

</body>
</html>
