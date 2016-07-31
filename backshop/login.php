<?php

    session_start(); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" />
</head>

<body>
<script src="../js/jquery-2.1.3.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<div class="container">
    <br>
        <div class="row">
            <div class="span5 offset3">
	<?php
        if(isset($_SESSION['massageLogin'])){  
            if($_SESSION['massageLogin'] == "Fail")
            {
                echo '<div class="alert alert-error">';
                echo '<button type="button" class="close" data-dismiss="alert"> &times </button>';
                echo "ไม่สามารถเข้าสู่ระบบได้ กรณาลองใหม่ <br>";
                echo "กรณาลองใหม่";
                echo '</div>';
                unset($_SESSION["massageLogin"]);
            }
        }
        ?>
            </div>
        </div>
<?php

	include("method/configDB.php"); //connect DB
	
	
	
	if (isset($_POST["SignIn"])) {
		
		$strUsername = ($_POST['txtUsername']);
		$strPassword = ($_POST['txtPassword']);
		$sql = "SELECT * FROM employee WHERE Emp_User = '$strUsername'
		and Emp_Pass = '$strPassword' and Emp_status='Open'";
		$result = mysqli_query($conn,$sql);
		$resultData = mysqli_fetch_array($result);
		
		if(!$resultData){
                    
                        $_SESSION["massageLogin"] = "Fail";
                        header("location:login.php");
                }
	
		else{	
			$_SESSION["UserID"] = $resultData["Emp_Id"];
			$_SESSION["UserLV"] = $resultData["Emp_Lv"];
			header("location:index.php");
		}
			   
	}
	mysqli_close($conn); 
?>


    <br>
	<div class="row">
            <div class="span5 offset3">
		<div class="well">
		
                                    
                    <form class="form-signin" role="form" method="post" action="login.php">
                      <fieldset class="centerForm">
                        <p class="text-center"><legend>SIGN UP</legend></p>
                        <label>User Name</label>
                        <input type="text" class="form-control" name="txtUsername" placeholder="Username" required autofocus>
                        <label>Password</label>
                        <label>
                          <input type="password" class="form-control" name="txtPassword" placeholder="Password" required>
                        </label>
                        <button class="btn btn-lg btn-primary btn-block" type="submit" name="SignIn">Login</button>
                      </fieldset>
                    </form>            
                                    
                                  
                </div>
            </div>
        </div>
</div>
<style type="text/css">
    .centerForm{
          margin: 0px 50px 0px;
    }
</style>
</body>
</html>
        
        
        