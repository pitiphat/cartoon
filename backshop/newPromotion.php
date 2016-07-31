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
if (isset($_POST["Enter"])) {

	
		
	$serverName   	= "localhost";
	$userName    	= "root";
	$userPassword   = "";
	$dbName   		= "cartoon";
	
    $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
	mysqli_set_charset($conn, 'utf8');
	
	$temp=$_POST['rentamount']+$_POST['freeamount'];
	$sql = 'select max(Promotion_Id)+1 as nextPromotionId from promotion';
		$result = mysqli_query($conn,$sql); 
		$load_Id = mysqli_fetch_array($result);
		
		if($load_Id['nextPromotionId']==null){ 
			$newBookId = '001'; 
		}
		else{
			$newBookId = sprintf('%03s',$load_Id['nextPromotionId']);
		}
		
	$sql = "insert into promotion (Promotion_Id, Pro_Borrow ,Discount, Pro_Status)
	VALUES ('$newBookId',{$temp},{$_POST['freeamount']},'Open')";  // คำสั่งที่เพิ่มข้อมุลลงไปในตาราง database บรรทัด value ด้วย
	echo $sql;
    
	$objQuery = mysqli_query($conn,$sql); // เอาตัวแปร sql มาคิวรี
	if($objQuery != ""){ 
	
		header("location:DataPromotion.php?page=promotion");				
	}
        else{ 
	
		header("location:newPromotion.php?page=promotion");				
	}
} 
?>
  <table>
      <form id="form1" name="form1" method="post" action="newPromotion.php">
  <p>
    <label for="textfield"></label>
  <table>
    
    <tr>
      <td>จำนวนหนังสือ<strong class="text-error" style="font-size: 20px">*</strong></td>
      <td><input type ="text" name="rentamount" required> เล่ม </td>
    </tr>
    <tr>
	</tr>
    <tr>
      <td>ฟรี <strong class="text-error" style="font-size: 20px">*</strong></td>
      <td><input type ="text" name="freeamount" required> เล่ม</td>
    </tr>
       <tr>
           <td></td>
    <td colspan="2"><button type="submit" name="Enter" class="btn btn-warning">ยืนยัน</button></td>
  </tr>

  </table>
</form>
</body>
</html>

    
    </<div>
    </div>
</div>
</div>

</body>
</html>
