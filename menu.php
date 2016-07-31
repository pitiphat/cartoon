<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

</head>

<body>
	<div class="row"> <!--menu Left-->
			<div class="span3">
            	<div class="well">
            	<?php 

if(!isset($_SESSION['MemberUserID']))
	{
		Showform_Login();
		echo '<img src="img/PROMOTION.png"/>';
		include("backshop/method/showPromotion.php");
	}
	
	else{
		Showform_Logout();
                echo '<img src="img/PROMOTION.png"/>';
                include("backshop/method/showPromotion.php");
	}
		?>  
				</div>
            </div>
            
</body>
</html>


<!--function show form login and logout-->
<?php
	function Showform_Login(){
		echo <<<HTMLBLOCK
			<form action="login.php" method="post">
				<table>
					<tr>
						<td>ชื่อผู้ใช้</td>
					</tr>
					<tr>
						<td><input name="memID" type="text" style="width:165px"/></td>
					</tr>
					<tr>
						<td>password</td>
					</tr>
					<tr>
						<td><input name="memPass" type="password" style="width:165px"/></td>
					</tr>
					<tr>
						<td><button type="submit" name="MemSignIn" class="btn btn-warning">เข้าสู่ระบบ</button></td>
					</tr>
				</table>
			</form>
HTMLBLOCK;
			}
			
			function Showform_Logout(){
				echo '<a href="logout.php">ออก</a>';
			}
?>
