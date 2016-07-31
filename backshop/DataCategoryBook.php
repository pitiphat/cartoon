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
<title>Category</title>
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
$eStatusStr=array("Open", "Close");
		
		$htmlEmpStatus = '<select name="cateStatus">';
		foreach($eStatusStr as $status_value){
			if(isset($dataLoad) && $status_value ==$dataLoad['Category_Status']){
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
			$sql = "select * from category_book where Category_Id='{$_GET['edit']}'";
			$result = mysqli_query($conn,$sql);
			$dataLoad = mysqli_fetch_array($result);
}
//-----------------------------------------กำหนดปุ่มลบ
if(isset($_GET['Delete'])){
				
		$sql = "update category_book set category_Status='Close' where category_Id = '{$_GET ['Delete']}'";
		$result = mysqli_query($conn,$sql);
		header("location:DataCategoryBook.php?page=category&subMenu=2");
}
//--------------------------------------------------------------หน้าแก้ไขหมวดหมู่
if(isset($_GET['edit'])){
	echo <<<HTMLBLOCK
	<table>
  <form method="post" action="CategoryBook.php">

	  <tr>
	    <td>รหัสหมวดหมู่หนังสือ </td>
	    <td><input type="text" name="Category_Id" value="{$dataLoad['Category_Id']}" maxlength="3"readonly/></td>
      </tr>
	   <tr>
	    <td>ชื่อหมวดหมู่ <strong class="text-error" style="font-size: 20px">*</strong></td>
	    <td><input type="text" name="Category_Name" value="{$dataLoad['Category_Name']}" maxlength="20" required/></td>
      </tr>
	   <tr>
	    <td>สถานะหมวดหมู่หนังสือ <strong class="text-error" style="font-size: 20px">*</strong></td>
	    <td>$htmlEmpStatus</td>
      </tr>
	  <tr>
	    <td></td>
	    <td colspan="2"><button type="submit" name="Category_button" class="btn btn-warning">ยืนยันข้อมูลหนังสือ</button></td>
      </tr>
</table>
HTMLBLOCK;
}
//-----------------------------------------------------------ตารางข้อมูลหมวดหมู่
else{
	$sql = 'select * from category_book';
	$result = mysqli_query($conn,$sql);
        echo"<p class='text-right'><a class='btn-small btn-primary' href='newCategory.php?page=category'><i class='icon-plus-sign icon-white'></i>เพิ่ม</a></p>";
	$html = '<table class="table table-hover">';
	
	
	$html = $html .'<tr><td>รหัสหมวดหมู่หนังสือ</td> <td>ชื่อหมวดหมู่หนังสือ</td> <td>สถานะของหมวดหมู่หนังสือ </td>';
	
	while($array=mysqli_fetch_array($result)){
		
$html = $html .'<tr class="success"><td>'.$array['Category_Id'].'</td>';
$html = $html .'<td>'. $array['Category_Name'].'</td>';
$html = $html .'<td>'. $array['Category_Status'].'</td>'; 
$html = $html .'<td>'.'<a href=DataCategoryBook.php?page=category&subMenu=2&edit='.$array['Category_Id'].'>แก้ไข</a></td>';
$html = $html .'<td>'.'<a href=DataCategoryBook.php?page=category&subMenu=2&Delete='.$array['Category_Id'].'>ปิดใช้งาน</a></td></tr>';
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
