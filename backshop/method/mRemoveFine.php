<?php

    session_start(); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">
<?php
	if(!isset($_SESSION['UserID']))
	{
		include("../login.php");
		exit();	
	}
?>
<?php
	include("configDB.php"); //connect DB
	if(isset($_POST["btnRemoveFine"])) {
		$sql = "UPDATE fine
				SET Fine_Status='Close'
				WHERE Fine_Id='{$_POST['fine_Id']}'";
		$result = mysqli_query($conn,$sql);
	
	}
	if($result){
		echo '<div class="alert alert-success">';
		echo "remove fine success";
		echo "<br>";
		echo '<a href="http://localhost/Cartoon/backshop/index.php?page=book">กลับหน้าหลัก</a></li>';
		echo '</div>';
	}
?>
</div>
</body>
</html>
