<?php
    session_start(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Untitled Document</title>


<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
    include("backshop/method/configDB.php");
	
	if (isset($_POST["MemSignIn"])) {
		
		$strUsername = ($_POST['memID']);
		$strPassword = ($_POST['memPass']);
		$sql = "SELECT * FROM member WHERE Mem_User = '$strUsername'
                        and Mem_Pass = '$strPassword' and Mem_status='Open'";
		$result = mysqli_query($conn,$sql);
		$resultData = mysqli_fetch_array($result);
		
		if(mysqli_num_rows($result)>=1){
			$_SESSION["MemberUserID"] = $resultData["Mem_Id"];
			header("location:index.php");
		}
		else{
			echo "<script language='javascript'> alert('ข้อมูลไม่ถูกต้องกรุณาลองใหม่'); </script>";
			echo "<meta http-equiv='refresh' content='0; url=index.php'>";
		}
			mysqli_close($conn);
	}
?>
</body>
</html>
