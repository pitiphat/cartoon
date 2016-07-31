<?php

    session_start(); 

?>
<?php
include("backshop/method/configDB.php");
if(isset($_POST['btnEditMember'])){
	checkValidate();
        if($_POST['memGender']=="ชาย"){
            $gender = "M";
        }
        else{
            $gender = "F";
        }
			$sql = "UPDATE Member
				SET Mem_User='{$_POST['memUser']}',Mem_Pass='{$_POST['memPass']}',
				Mem_Name='{$_POST['memName']}', Mem_Lastname='{$_POST['memLastname']}',
				Address='{$_POST['memAddress']}',Tel='{$_POST['memTel']}'
                                ,Id_Card='{$_POST['idCard']}',Gender='{$gender}'
				WHERE Mem_Id='{$_SESSION['MemberUserID']}'";
                                
			$result = mysqli_query($conn,$sql);
	
			if($result){
                                $_SESSION["massageFrontShop"] = "success";
                                header("location:editMember.php?page=editMember");
                        }
                        else{
                                $_SESSION["massageFrontShop"][] = "username ซ้ำ";
                                header("location:editMember.php?page=editMember");
                                exit();
                        }
		}
		
		
		
		function checkValidate(){  
			
			$error=array();
			if(preg_match('/^[a-zA-Z0-9]{1,8}$/',$_POST['memUser'])==0){
					$error[] = 'ค่าข้อมูลชื่อผู้ใช้งานในระบบไม่ถูกต้องง ต้องเป็นตัวอักษร หรือตัวเลขไม่เกิน 8 ตัวอักษร';
			}
			if(preg_match('/^[a-zA-Z0-9]{1,8}$/',$_POST['memPass'])==0){
					$error[] = 'ค่าข้อมูลรหัสผ่านไม่ถูกต้อง ต้องเป็นตัวอักษร หรือตัวเลขไม่เกิน 8 ตัวอักษร';
			}
			if(preg_match('/^[a-zA-Zก-เ]*$/',$_POST['memName'])==0){
					$error[] = 'ค่าข้อมูล ชื่อ ไม่ถูกต้อง ต้องเป็นตัวอักษรเท่านั้น';
			}
			if(preg_match('/^[a-zA-Zก-เ]*$/',$_POST['memLastname'])==0){
					$error[] = 'ค่าข้อมูล นามสกุล ไม่ถูกต้อง ต้องเป็นตัวอักษรเท่านั้น';
			}
			if(preg_match('/^\d{9,10}$/',$_POST['memTel'])==0){
					$error[] = 'ค่าข้อมูล เบอร์โทรศัพ ไม่ถูกต้อง ต้องเป็นตัวเลข 10 หลัก';
			}
                        if(preg_match('/^\d{13}$/',$_POST['idCard'])==0){
					$error[] = 'รหัสบัตรประชาชนไม่ถูกต้อง ต้องเป็นตัวเลข 13 หลัก';
			}
			
			if(count($error)>0){
                            foreach($error as $e){
                            $_SESSION["massageFrontShop"][] = $e;
                            }
                            
                            header("location:editMember.php?page=employee");
                            exit();	
			}
		}
mysqli_close($conn);
?>
