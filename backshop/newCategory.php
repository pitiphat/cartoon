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
if (isset($_POST["Category_button"])) {
	
	
		
	$serverName   	= "localhost";
	$userName    	= "root";
	$userPassword   = "";
	$dbName   	= "cartoon";
	
        $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
	mysqli_set_charset($conn, 'utf8');
	
	
	$sql = 'select max(Category_Id)+1 as nextBookId from category_book';
		$result = mysqli_query($conn,$sql); 
		$load_Id = mysqli_fetch_array($result);
		
		if($load_Id['nextBookId']==null){ 
			$newBookId = '001'; 
		}
		else{
			$newBookId = sprintf('%03s',$load_Id['nextBookId']);
		}
		
	$sql = "insert into category_book (Category_Id, Category_Name,Category_Status)
	VALUES ('$newBookId','{$_POST['Category_Name']}','Open')";  // คำสั่งที่เพิ่มข้อมุลลงไปในตาราง database บรรทัด value ด้วย
	
    
	$objQuery = mysqli_query($conn,$sql); // เอาตัวแปร sql มาคิวรี
	if($objQuery != ""){
		
		header("location:DataCategoryBook.php?page=category");
        }
        else{  
                header("location:newCategory.php?page=category");
        }   
}
	
?>
  <table>
  <form method="post" action="newCategory.php">
	  <tr>
	    <td>ชื่อหมวดหมู่หนังสือ <strong class="text-error" style="font-size: 20px">*</strong></td>
	    <td><input type="text" maxlength ="20" name="Category_Name" required/></td>
      </tr>
	  <tr>
	    <td></td>
	    <td colspan="2"><button type="submit" name="Category_button" class="btn btn-warning">เพิ่มข้อมูลหนังสือ</button></td>
      </tr>
	   
</table>
    
    </<div>
    </div>
</div>
</div>

</body>
</html>
