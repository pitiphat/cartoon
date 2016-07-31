<?php

    session_start(); 

?>
<?php
if(!isset($_SESSION['UserID']))
	{
		include("../login.php");
		exit();	
	}
?>
<?php
		include("configDB.php"); //connect DB
		
		$statusFine = "Open";
		if(isset($_POST["btnNewFine"])) {
                    checkValidate();

                    $sql = "insert into fine (Fine_Id, Fine_Price, Fine_Status) 
                    values('{$_POST['fineId']}', {$_POST['finePrice']}, '$statusFine')";

		$result = mysqli_query($conn,$sql);
		}
		if($result){
                    $_SESSION["massageEditbook"] = "success";
                    header("location:../manageFine.php?page=fine&subMenu=1");
		}
                else{
                     $_SESSION["massageEditbook"][] = "ราคาค่าปรับ ซ้ำ";
                     header("location:../newFine.php?page=fine&subMenu=2");
                     exit();
                }
			
			
		function checkValidate(){
			$error=array();
			if(preg_match('/^[1-9][0-9]{0,2}$/',$_POST['finePrice'])==0){
					$error[] = 'ค่าข้อมูลราคาค่าปรับ ไม่ถูกต้องต้องเป็นตัวเลขไม่เกิน 4 หลัก';
			}
			if(count($error)>0){
                            foreach($error as $e){
                            $_SESSION["massageEditbook"][] = $e;
                            }
                            
                            header("location:../newFine.php?page=fine&subMenu=2");
                            exit();
			}
		}
?>
