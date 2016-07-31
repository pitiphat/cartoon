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
		if(isset($_POST["btnEditFine"])) {
			checkValidate();
                        
                    if($_POST['fineStatus']=="เปิดใช้งาน"){
                        $status="Open";
                    }
                    else if($_POST['fineStatus']=="ปิดใช้งาน"){
                        $status="Close";
                    }
                   
                    
			$sql = "UPDATE fine
				SET Fine_Price={$_POST['finePrice']},Fine_Status='$status'
				WHERE Fine_Id='{$_POST['fineId']}'";
                                
			$result = mysqli_query($conn,$sql);

		}
		if($result){
                    $_SESSION["massageEditbook"] = "success";
                    header("location:../manageFine.php?page=fine&subMenu=1");
		}
                else{
                     $_SESSION["massageEditbook"][] = "ราคาค่าปรับ ซ้ำ";
                     header("location:../manageFine.php?page=fine&subMenu=1&edit={$_POST['fineId']}");
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
                            
                            header("location:../manageFine.php?page=fine&subMenu=1&edit={$_POST['fineId']}");
                            exit();
			}
		}
		mysqli_close($conn);
?>
