
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

             if(isset($_POST["btnEditBook"])) { // หลังจาก กดปุ่มบันทึก
                 checkValidate();
                 
                    if($_POST['bookStatus']=="ยืมได้"){
                        $status="True";
                    }
                    else if($_POST['bookStatus']=="ถูกยืมไปแล้ว"){
                        $status="False";
                    }
                    else if($_POST['bookStatus']=="สูญหาย"){
                        $status="Invisible";
                    }
                    else{
                        $status="Remove";
                    }

                $sql = "UPDATE book_detail
                        SET Book_No='{$_POST['bookName']}',vol='{$_POST['vol']}'
                        ,Book_Status='$status' WHERE Book_Id='{$_POST['book_Id']}'";

                $result = mysqli_query($conn,$sql);
                
                if($result){
     
                    $_SESSION["massageEditbook"] = "success";
                    header("location:../manageBook.php?page=book&subMenu=2");
                }
             }

		
	mysqli_close($conn);
        
        function checkValidate(){ 
            $_SESSION["massageEditbook"] = null;
                $error=array();
                if(preg_match('/^[1-9][0-9]{0,3}$/',$_POST['vol'])==0){
                    
                    $error[] = 'ค่าข้อมูล เล่มที่ ไม่ถูกต้องต้องเป็นตัวเลขไม่เกิน 4 หลัก';

                }
                if(count($error)>0){
                    foreach($error as $e){
                    $_SESSION["massageEditbook"][] = $e;
                    }

                    header("location:../manageBook.php?page=book&subMenu=2&edit={$_POST['book_Id']}");
                    exit();
                           
                }
            }
?>
    
  