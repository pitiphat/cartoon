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
        $serverName   	= "localhost";
		$userName    	= "root";
		$userPassword   = "";
		$dbName   	= "cartoon";
        $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
	mysqli_set_charset($conn, 'utf8'); 


		//-------------------ปุ่มลบ
		
		if(isset($_GET['Delete'])){
				
		$sql = "update member set Mem_Status='Close' where Mem_Id = '{$_GET ['Delete']}'";
		$result = mysqli_query($conn,$sql);
		header("location:DataMember.php?page=member");
		}
	
		//--------------------------------------------ปุ่มแก้ไข
		
        if(isset($_GET['edit'])){
                $sql = "select * from member where Mem_Id='{$_GET['edit']}'";
                $result = mysqli_query($conn,$sql);
                $dataLoad = mysqli_fetch_array($result);
		
		
		//-----------------------------หน้าแก้ไขสมาชิก
		
		
	echo <<<HTMLBLOCK
	<table>
  <form method="post" action="Member.php">
<tr>
    <td>รหัสสมาชิก <strong class="text-error" style="font-size: 20px">*</strong></td>
    <td><input type="text" name="memid" placeholder="" value="{$dataLoad['Mem_Id']}" maxlength="8" readonly/></td>

  </tr>
 <tr>
    <td>ชื่อผู้ใช้ <strong class="text-error" style="font-size: 20px">*</strong></td>
    <td><input type="text" name="username" placeholder="ชื่อใช้งานในระบบ" value="{$dataLoad['Mem_User']}" readonly/></td>

  </tr>
  <tr>
    <td>รหัสผ่าน <strong class="text-error" style="font-size: 20px">*</strong></td>
    <td><input type="password" name="password" id="Password"   value="{$dataLoad['Mem_Pass']}" maxlength="8"size="8"placeholder="ใส่รหัสผ่าน" /></td>
  </tr>
  <tr>
    <td>รหัสบัตรประชาชน <strong class="text-error" style="font-size: 20px">*</strong></td>
    <td><input type="text" name="Id_Card"  value="{$dataLoad['Id_Card']}" maxlength="13"  placeholder="ใส่เลข13  หลัก"required/></td>
  </tr>
  <tr>
    <td>ชื่อ <strong class="text-error" style="font-size: 20px">*</strong></td>
    <td><input type="text" name="Mem_Name" value="{$dataLoad['Mem_Name']}" required/></td>
  </tr>
  <tr>
    <td>นามสกุล <strong class="text-error" style="font-size: 20px">*</strong></td>
    <td><input type="text" name="Mem_Lastname" value="{$dataLoad['Mem_Lastname']}" required/></td>
  </tr>
  <tr>
    <td>เพศ <strong class="text-error" style="font-size: 20px">*</strong></td>
    <td><select name="gender"><option value="M">ชาย</option><option value="F" >หญิง</option></select></td>
  </tr>
  <tr>
    <td>ที่อยู่ <strong class="text-error" style="font-size: 20px">*</strong></td>
    <td><textarea name="address" rows="3" id="address" placeholder="ที่อยู่ปัจจุบัน" />{$dataLoad['Address']}</textarea></td>
  </tr>
  <tr>
    <td>เบอร์โทร <strong class="text-error" style="font-size: 20px">*</strong></td>
    <td><input type="text" name="Tel" value= "{$dataLoad['Tel']}" maxlength="10"="ใส่เลข 10 หลัก"required/></td>
  </tr>
    <tr>
    <td>สถานะ <strong class="text-error" style="font-size: 20px">*</strong></td>
    <td><select name="MemStatus"><option value="Open">เปิดใช้งาน</option><option value="Close" >ปิดใช้งาน</option></select></td>
  </tr>
	 
	  <tr><td></td>
    <td colspan="2"><button type="submit" name="Register" class="btn btn-warning">ยืนยันการแก้ไขข้อมูล</button></td>
  </tr>
</table>
HTMLBLOCK;
}

else{

		//----------------------------------------------------ตารางข้อมูลสมาชิก
	$sql = 'select * from member';
	$result = mysqli_query($conn,$sql);
        echo"<p class='text-right'><a class='btn-small btn-primary' href='newMember.php?page=member'><i class='icon-plus-sign icon-white'></i>เพิ่ม</a></p>";
	$html = '<table class="table table-hover">';
	$html = $html .'<tr class="info"><td>รหัสสมาชิก</td> <td>ชื่อ</td> <td>นามสกุล</td> <td>ชื่อผู้ใช้</td> <td>สถานะ</td><td></td><td></td></tr>';
	
	
	while($array=mysqli_fetch_array($result)){
	
$html = $html .'<tr class="success"><td>'.$array['Mem_Id'].'</td>';
$html = $html .'<td>'. $array['Mem_Name'].'</td>';  
$html = $html .'<td>'.$array['Mem_Lastname'].'</td>';  
$html = $html .'<td>'.$array['Mem_User'].'</td>';
$html = $html .'<td>'.$array['Mem_Status'].'</td>';
$html = $html .'<td>'.'<a href=DataMember.php?page=member&subMenu=2&edit='.$array['Mem_Id'].'>แก้ไข</a></td>';
$html = $html .'<td>'.'<a href=DataMember.php?page=member&subMenu=2&Delete='.$array['Mem_Id'].'>ปิดใช้งาน</a></td></tr>';

}
$html = $html .'</table>';


if(mysqli_num_rows($result)>0)
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
