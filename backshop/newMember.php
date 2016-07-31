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
<title>Member</title>
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
if (isset($_POST["Register"])) {

				
	$serverName   	= "localhost";
	$userName    	= "root";
	$userPassword   = "";
	$dbName   		= "cartoon";
	
    $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
	mysqli_set_charset($conn, 'utf8');
	
		
	$sql = 'select max(Mem_Id)+1 as nextMemId from member';
		$result = mysqli_query($conn,$sql); 
		$load_Id = mysqli_fetch_array($result);
		
		if($load_Id['nextMemId']==null){ 
			$newMemId = '00000001'; 
		}
		else{
			$newMemId = sprintf('%08s',$load_Id['nextMemId']);
		}
	
	
	$sql  = "insert into member (Mem_Id,Mem_name,Mem_Lastname,Mem_User,Mem_Pass,Gender,Address,Tel,Mem_Status,Id_Card) 
		VALUES ('$newMemId','".$_POST["Mem_Name"]."','".$_POST["Mem_Lastname"]."','".$_POST["username"]."','".$_POST["password"]."','".$_POST["gender"]."','".$_POST["address"]."','".$_POST["Tel"]."','Open','".$_POST["Id_Card"]."')"; 
	// คำสั่งที่เพิ่มข้อมุลลงไปในตาราง database บรรทัด value ด้วย
    $objQuery = mysqli_query($conn,$sql); // เอาตัวแปร sql มาคิวรี
		if($objQuery != ""){
                    header("location:printMemberCard.php?memid={$newMemId}&memName={$_POST["Mem_Name"]}&memLname={$_POST["Mem_Lastname"]}");
                    
		}
                else{
                    header("location:dataMember.php?page=member");
                }
	
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Member</title>
</head>
<body>
<label for="textfield"></label>
<table>
  
<form action ="newMember.php" method="post">
	
  <tr>
    <td>ชื่อผู้ใช้ <strong class="text-error" style="font-size: 20px">*</strong></td> 
    <td><input type="text" name="username" placeholder="ชื่อในระบบ" maxlength="20" required/></td>

  </tr>
  <tr>
    <td>รหัสผ่าน <strong class="text-error" style="font-size: 20px">*</strong></td>
    <td><input type="Password" name="password" id="Password"maxlength="8"size="8"placeholder="ใส่รหัสผ่าน" required/></td>
  </tr>
  <tr>
    <td>รหัสบัตรประชาชน <strong class="text-error" style="font-size: 20px">*</strong></td>
    <td><input type="text" name="Id_Card" placeholder="ใส่เลข13  หลัก" maxlength="13" required/></td>
  </tr>
  <tr>
    <td>ชื่อ <strong class="text-error" style="font-size: 20px">*</strong></td>
    <td><input type="text" name="Mem_Name" required/></td>
  </tr>
  <tr>
    <td>นามสกุล <strong class="text-error" style="font-size: 20px">*</strong></td>
    <td><input type="text" name="Mem_Lastname" required/></td>
  </tr>
  <tr>
    <td>เพศ <strong class="text-error" style="font-size: 20px">*</strong></td>
    <td><select name="gender"><option value="M">ชาย</option><option value="F" >หญิง</option></select></td>
  </tr>
  <tr>
    <td>ที่อยู่ <strong class="text-error" style="font-size: 20px">*</strong></td>
    <td><textarea name="address" rows="3"id="address"placeholder="ที่อยู่ปัจจุบัน"/></textarea></td>
  </tr>
  <tr>
    <td>เบอร์โทร <strong class="text-error" style="font-size: 20px">*</strong></td>
    <td><input type="text" name="Tel" id=""placeholder="" maxlength="10" required /></td>
  </tr>

  <tr><td></td>
    <td colspan="2"><button type="submit" name="Register" class="btn btn-warning">ยืนยันการสมัคร</button></td>
  </tr>
</table>
    
    </<div>
    </div>
</div>
</div>

</body>
</html>
