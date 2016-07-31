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
<title>Promotion</title>
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
            $serverName   	= "localhost"; //เชื่อมต่อฐานข้อมูล
	$userName    	= "root";
	$userPassword   = "";
	$dbName   		= "cartoon";
	
    $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
	mysqli_set_charset($conn, 'utf8'); 
//-------------------------------------------กำหนดสถานะ เปิด ปิด 
$eStatusStr=array("Open","Close");
		
		$htmlEmpStatus = '<select name="ProStatus">';
		foreach($eStatusStr as $status_value){
			if(isset($dataLoad) && $status_value ==$dataLoad['Promotion_Status']){
				$select = 'selected';
			}
			else{
				$select = '';
			}
			$htmlEmpStatus .= "<option value=\"$status_value\" $select>$status_value</option>";
		}
		$htmlEmpStatus .= '</select>';
//--------------------------------------กำหนดปุ่มแก้ไข
if(isset($_GET['edit'])){
    $sql = "select * from promotion where Promotion_Id='{$_GET['edit']}'";
    $result = mysqli_query($conn,$sql);
    $dataLoad = mysqli_fetch_array($result);
}
//-----------------------------------------กำหนดปุ่มลบ
if(isset($_GET['Delete'])){
				
    $sql = "update promotion set Pro_Status='Close' where Promotion_Id = '{$_GET ['Delete']}'";
    $result = mysqli_query($conn,$sql);
    header("location:DataPromotion.php?page=promotion&subMenu=2");
}
//--------------------------------------------------------------หน้าแก้ไขโปรโมชั่น
if(isset($_GET['edit'])){
    $temp=$dataLoad['Pro_Borrow']- $dataLoad['Discount'];
	echo <<<HTMLBLOCK
	<table>
  <form method="post" action="Promotion.php">

    <tr>
	    <td>รหัสโปรโมชัน</td>
	    <td><input type ="text" name="proid" value="{$dataLoad['Promotion_Id']}"readonly/></td>
      </tr>
	  <tr>
	    <td>จำนวนหนังสือ <strong class="text-error" style="font-size: 20px">*</strong></td>
	    <td><input type ="text" name="proborrow" value="{$temp}" required/> เล่ม</td>
      </tr>
	   <tr>
	    <td>ฟรี <strong class="text-error" style="font-size: 20px">*</strong></td>
	    <td><input type ="text" name="discount" value="{$dataLoad['Discount']}" required/> เล่ม</td>
      </tr>
      <tr>
      <td>สถานะ <strong class="text-error" style="font-size: 20px">*</strong></td>
	    <td>$htmlEmpStatus</td>
      </tr>
	  <tr>
	    <td>
	    <td colspan="2"><button type="submit" name="Enter" class="btn btn-warning">ยืนยัน</button></td>
      </tr>
</table>
HTMLBLOCK;
}
//-----------------------------------------------------------ตารางข้อมูลโปรโมชั่น
else{
	$sql = "select * from promotion where Promotion_Id!='000'";
	$result = mysqli_query($conn,$sql);
        echo"<p class='text-right'><a class='btn-small btn-primary' href='newPromotion.php?page=promotion'><i class='icon-plus-sign icon-white'></i>เพิ่ม</a></p>";
	$html = '<table class="table table-hover">';
	
	
	$html = $html .'<tr><td>จำนวนหนังสือ</td> <td>ฟรี</td> <td>สถานะโปรโมชั่น</td>';
	
	while($array=mysqli_fetch_array($result)){
            $temp= $array['Pro_Borrow'] - $array['Discount'];
		
$html = $html .'<tr class="success"><td>'.$temp.'</td>';
$html = $html .'<td>'. $array['Discount'].'</td>';
$html = $html .'<td>'. $array['Pro_Status'].'</td>'; 
$html = $html .'<td>'.'<a href=DataPromotion.php?page=promotion&subMenu=2&edit='.$array['Promotion_Id'].'>แก้ไข</a></td>';
$html = $html .'<td>'.'<a href=DataPromotion.php?page=promotion&subMenu=2&Delete='.$array['Promotion_Id'].'>ปิดใช้งาน</a></td></tr>';
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
