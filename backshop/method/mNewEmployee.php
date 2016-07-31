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
        if(isset($_POST["btnNewEmployee"])) {
            

                checkValidate();

                $sql = "insert into employee (Emp_Id, Emp_User, Emp_Pass, Emp_Name, Emp_Lastname, Emp_LV,
                                Gender, Address, Tel, Emp_Status) 
                                values('{$_POST['empId']}', '{$_POST['empUser']}', '{$_POST['empPass']}',
                                '{$_POST['empName']}', '{$_POST['empLastname']}', '{$_POST['LV']}',
                                '{$_POST['gender']}','{$_POST['address']}', '{$_POST['Tel']}','Open')";
                $result = mysqli_query($conn, $sql);

                if($result){
                   $_SESSION["massageEditbook"] = "success";
                    header("location:../manageEmployee.php?page=employee&subMenu=1");
                }
                else{
                    $_SESSION["massageEditbook"][] = "username ซ้ำ";
                    header("location:../newEmployee.php?page=employee&subMenu=2");
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
            if(preg_match('/^\d{9,10}$/',$_POST['Tel'])==0){
                            $error[] = 'ค่าข้อมูล เบอร์โทรศัพ ไม่ถูกต้อง ต้องเป็นตัวเลข 9-10 หลัก';
            }

            if(count($error)>0){
               foreach($error as $e){
                    $_SESSION["massageEditbook"][] = $e;
               }
                            
                    header("location:../newEmployee.php?page=employee&subMenu=2");
                    exit();
            }
    } 

mysqli_close($conn);
?>
</div>
