<?php

    session_start(); 

        if(!isset($_SESSION['UserID']))
	{
		include("../login.php");
		exit();	
	}
?>
<?php
		include("configDB.php"); //connect DB
                include 'fnc_chanceYear.php';
                $tempDate=changeDateSwap($_POST['bookIndate']);
		
		$statusBook = "True";
		
		if(isset($_POST["addNewBook"])) {
                    $tmpBookID=$_POST['bookId'];
                    $newBookId = sprintf('%08s',$tmpBookID);
                    
			//checkValidate();
                    if(strstr($_POST['vol'],"-")){
                        
                        $pieces = explode("-", $_POST['vol']);
                        for($i=$pieces[0];$i <= $pieces[1];$i++){
                            
                            $sql = "insert into book_detail (Book_Id, Book_No, Book_Indate, Vol, Book_Status)
                                    values('{$newBookId}','{$_POST['bookName']}','{$tempDate}','{$i}','$statusBook')";
                            $result = mysqli_query($conn,$sql);
                        
                            $tmpBookID++;
                            $newBookId = sprintf('%08s',$tmpBookID);
                        
                        }
                        
                       
                    }
                    else if(strstr($_POST['vol'],",")){
                        $tmpBookID=$_POST['bookId'];
                        $newBookId = sprintf('%08s',$tmpBookID);
                        $pieces = explode(",", $_POST['vol']);
                        for($i=0;$i < count($pieces);$i++){
                            
                            $sql = "insert into book_detail (Book_Id, Book_No, Book_Indate, Vol, Book_Status)
                                    values('{$newBookId}','{$_POST['bookName']}','{$tempDate}','{$pieces[$i]}','$statusBook')";
                            $result = mysqli_query($conn,$sql);
                           
                            $tmpBookID++;
                            $newBookId = sprintf('%08s',$tmpBookID);
                        
                        }
                        
                    }
                    else{

			$sql = "insert into book_detail (Book_Id, Book_No, Book_Indate, Vol, Book_Status)
                                values('{$_POST['bookId']}','{$_POST['bookName']}','{$tempDate}','{$_POST['vol']}','$statusBook')";
                        $result = mysqli_query($conn,$sql);
                    }
                }
		if($result){
                        $_SESSION["massageEditbook"] = "success";
                        header("location:../manageBook.php?page=book&subMenu=2");
		}
		
		function checkValidate(){ 
                        $_SESSION["massageEditbook"] = null;
			$error=array();
			if(preg_match('/^\d{1,3}$/',$_POST['vol'])==0){
					$error[] = 'ค่าข้อมูล เล่มที่ ไม่ถูกต้องต้องเป็นตัวเลขไม่เกิน 4 หลัก';
			}
			if(count($error)>0){
                            foreach($error as $e){
                            $_SESSION["massageEditbook"][] = $e;
                            }
                            
                            header("location:../newBook.php?page=book&subMenu=2");
                            exit();
			}
		}
		mysqli_close($conn);
?>
