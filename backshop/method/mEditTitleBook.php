<?php

    session_start(); 

    if(!isset($_SESSION['UserID']))
    {
        include("login.php");
        exit();	
    }
    
    
?>
    <?php
	include("configDB.php"); //connect DB

             if(isset($_POST["btnEditTitle"])) { // หลังจาก กดปุ่มบันทึก
                 checkValidate();
                 
                if($_POST['bookStatus']=="เปิดใช้งาน"){
                    $status="Open";
                }
                else if($_POST['bookStatus']=="ปิดการใช้งาน"){
                   $status="Remove";
                }
                $sql = "UPDATE book
                        SET ISBN='{$_POST['isbn']}',Book_Name='{$_POST['bookName']}',Press='{$_POST['press']}',
                        Rent_Price='{$_POST['rentPrice']}',Date_Quantity='{$_POST['d_quan']}',Category_Id='{$_POST['categoryId']}',Fine_Id='{$_POST['fineId']}',
                        Title_Status='$status' WHERE Book_No='{$_POST['bookNo']}'";
                        echo $sql;
                        

                $result = mysqli_query($conn,$sql);
                
                if($result){
     
                    $_SESSION["massageEditbook"] = "success";
                    header("location:../manageTitleBook.php?page=book&subMenu=1");
                }
                 else{
                     $_SESSION["massageEditbook"][] = "ชื่อหนังสือ ซ้ำ";
                     header("location:../manageTitleBook.php?page=book&subMenu=1&edit={$_POST['bookNo']}");
                     exit();
                }
             }

		
	mysqli_close($conn);
        
        function checkValidate(){
                $_SESSION["massageEditbook"] = null;
                $error=array();
			if(preg_match('/^\d{13}$/',$_POST['isbn'])==0){
					$error[] = 'ค่าข้อมูล ISBN ไม่ถูกต้อง ต้องเป็นตัวเลข 13 หลัก';
			}
			if(preg_match('/^[a-zA-Zก-เ0-9]*$/',$_POST['bookName'])==0){
					$error[] = 'ค่าข้อมูลชื่อหนังสือไม่ถูกต้อง ต้องเป็นตัวอักษร หรือตัวเลข ไม่เกิน 25 ตัวอักษร';
			}
			if(preg_match('/^[a-zA-Zก-เ[:space:]]*$/',$_POST['press'])==0){
					$error[] = 'ค่าข้อมูลสำนักพิมพ์ไม่ถูกต้อง ต้องเป็นตัวอักษร หรือตัวเลข ไม่เกิน 25 ตัวอักษร';
			}
			if(preg_match('/^[0-9]{1,4}$/',$_POST['rentPrice'])==0){
					$error[] = 'ค่าข้อมูลค่าเช่าไม่ถูกต้อง ต้องเป็นตัวเลขจำนวนเต็ม หรือตัวเลข ไม่เกิน 4 หลัก';
			}
			if(preg_match('/^[0-9]{1,3}$/',$_POST['d_quan'])==0){
					$error[] = 'ค่าข้อมูลจำนวนวันที่เช่าไม่ถูกต้อง ต้องเป็นตัวเลขจำนวนเต็ม หรือตัวเลข ไม่เกิน 3 หลัก';
			}
                if(count($error)>0){
                            foreach($error as $e){
                            $_SESSION["massageEditbook"][] = $e;
                            }
                            
                            header("location:../manageTitleBook.php?page=book&subMenu=1&edit={$_POST['bookNo']}");
                            exit();
                }
            }
?>