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
	
	if(isset($_POST['btnEditEmployee'])) {
		
             if($_POST['empStatus']=="เปิดใช้งาน"){
                $status="Open";
             }
             else if($_POST['empStatus']=="ปิดใช้งาน"){
                $status="Close";
             }

            if($_POST['empLV']=="เจ้าของร้าน"){
                    $LV=99;
            }
            else{
                    $LV=1;
            }
            if($_POST['empGender']=="ชาย"){
                    $gen='M';
            }
            else if($_POST['empGender']=="หญิง"){
                    $gen='F';
            }
    
    
    
    checkValidate();
    $sql = "UPDATE Employee
            SET Emp_User='{$_POST['empUser']}',Emp_Pass='{$_POST['empPass']}',
            Emp_Name='{$_POST['empName']}', Emp_Lastname='{$_POST['empLastname']}',
            Emp_Lv=$LV, Gender='{$gen}', Address='{$_POST['empAddress']}',
            Tel='{$_POST['empTel']}', Emp_Status='$status'
            WHERE Emp_Id='{$_POST['empId']}'";
    $result = mysqli_query($conn,$sql);

            if($result){
                    $_SESSION["massageEditbook"] = "success";
                    header("location:../manageEmployee.php?page=employee&subMenu=1");
            }
            else{
                    $_SESSION["massageEditbook"][] = "username ซ้ำ";
                    header("location:../manageEmployee.php?page=employee&subMenu=1&edit={$_POST['empId']}");
                    exit();
                }
	}
	function checkValidate(){  
			
			$error=array();
			if(preg_match('/^[a-zA-Z0-9]{4,8}$/',$_POST['empUser'])==0){
					$error[] = 'ค่าข้อมูลชื่อผู้ใช้งานในระบบไม่ถูกต้องง ต้องเป็นตัวอักษร หรือตัวเลข 4 - 8 ตัวอักษร';
			}
			if(preg_match('/^[a-zA-Z0-9]{4,8}$/',$_POST['empPass'])==0){
					$error[] = 'ค่าข้อมูลรหัสผ่านไม่ถูกต้อง ต้องเป็นตัวอักษร หรือตัวเลข 4 - 8 ตัวอักษร';
			}
			if(preg_match('/^[a-zA-Zก-เ]*$/',$_POST['empName'])==0){
					$error[] = 'ค่าข้อมูล ชื่อ ไม่ถูกต้อง ต้องเป็นตัวอักษรเท่านั้น';
			}
			if(preg_match('/^[a-zA-Zก-เ]*$/',$_POST['empLastname'])==0){
					$error[] = 'ค่าข้อมูล นามสกุล ไม่ถูกต้อง ต้องเป็นตัวอักษรเท่านั้น';
			}
			if(preg_match('/^\d{9,10}$/',$_POST['empTel'])==0){
					$error[] = 'ค่าข้อมูล เบอร์โทรศัพ ไม่ถูกต้อง ต้องเป็นตัวเลข 9-10 หลัก';
			}
			
			if(count($error)>0){
                            foreach($error as $e){
                            $_SESSION["massageEditbook"][] = $e;
                            }
                            
                            header("location:../manageEmployee.php?page=employee&subMenu=1&edit={$_POST['empId']}");
                            exit();
			}
		} 
mysqli_close($conn);
?>
