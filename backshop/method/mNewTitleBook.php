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

                if(isset($_POST["addNewTitle"])) {
                   
                    
                        checkValidate();

                        //------------book
                        $sql = "insert into book (Book_No, ISBN, Book_Name, Press, Rent_Price, Date_Quantity, Category_Id, Fine_Id, Title_Status) values 
                                ('{$_POST['bookNo']}','{$_POST['isbn']}','{$_POST['bookName']}','{$_POST['press']}',{$_POST['rentPrice']}
                                ,{$_POST['d_quan']},'{$_POST['categoryId']}','{$_POST['fineId']}','Open')";
                        
                        
                                $result = mysqli_query($conn,$sql);
                       
                        //author
                        foreach ($_POST['field'] as $authorText){
                                if(empty($authorText)){
                                        continue;
                                }
                                $sql = "insert into author (Book_No, Author) values 
                                ('{$_POST['bookNo']}','$authorText')";
                                $result2 = mysqli_query($conn,$sql);
                        }
                }
		if($result){
			$_SESSION["massageEditbook"] = "success";
                        header("location:../manageTitleBook.php?page=book&subMenu=1");	
		}
                else{
                     $_SESSION["massageEditbook"][] = "ชื่อหนังสือ ซ้ำ";
                     header("location:../newTitleBook.php?page=book&subMenu=1");
                     exit();
                }
                
                
		function checkValidate(){
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
                            
                            header("location:../newTitleBook.php?page=book&subMenu=1");
                            exit();
			}
		} 
	
		mysqli_close($conn);
?>
</div>
