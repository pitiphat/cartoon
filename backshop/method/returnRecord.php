<?php

    session_start(); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
if(!isset($_SESSION['UserID']))
	{
		include("../login.php");
		exit();	
	}
?>
<?php
if(isset($_POST["btnReturn"])) {
			//-------------------------------------------- คำนวนราคารวม
			$bookid=array();
			$fineprice=array();
			$totalPrice=0;
			//$Borrow_Id = $_POST['Borrow_Id'];
			
			foreach ($_POST['bookid'] as $temp) { //อ่านราคาแต่ละแถว

				$bookid[]=$temp;
			}
			foreach ($_POST['fineprice'] as $temp) { //อ่านราคาแต่ละแถว

				$fineprice[]=$temp;
				$totalPrice+=$temp;
			}
			include("configDB.php"); //connect DB
			$sql = 'select max(Return_Id)+1 as newReturnId from return_book';
			$result = mysqli_query($conn,$sql); 
			$load_Id = mysqli_fetch_array($result);
			
			if($load_Id['newReturnId']==null){ 
				$newReturnId = '00000001'; 
			}
			else{ 
				$newReturnId = sprintf('%08s',$load_Id['newReturnId']); 
			}
			$sql = "insert into return_book (Return_Id, D_Return, Emp_Id, Total_Fine)
					value('$newReturnId','{$_POST['today']}','{$_SESSION['UserID']}',$totalPrice)";
			$result = mysqli_query($conn,$sql);
			
			for($i=0;$i<count($bookid);$i++){
                            $sql="select a1.Book_Id, a1.Vol, a2.Book_Name,a2.Date_Quantity, a3.Date_Borrow, 
                                    a5.Fine_Price, a4.Borrow_Id
                                    from book_detail a1, book a2 ,borrow a3, borrow_detail a4, fine a5
                                    where a1.Book_No=a2.Book_No and a3.Borrow_Id=a4.Borrow_Id
                                    and a1.Book_Id=a4.Book_Id and a1.Book_Status='False' and a4.Borrow_Status ='No'
                                    and a2.Fine_Id=a5.Fine_Id
                                    and a1.Book_Id='$bookid[$i]'";
                            $result=  mysqli_query($conn, $sql);
                            
                            $array = mysqli_fetch_array($result);
			$sql = "insert into return_detail (Return_Id, Borrow_Id, Book_Id, Fine)
				value('$newReturnId','{$array['Borrow_Id']}','{$bookid[$i]}','{$fineprice[$i]}')";
			$result = mysqli_query($conn,$sql);
			
			}
			
			for($i=0;$i<count($bookid);$i++){
                            
				$sql = "update book_detail set Book_Status = 'True'
					where Book_Id = '{$bookid[$i]}'";
				$result = mysqli_query($conn,$sql);
			
                                $sql="select a1.Book_Id, a1.Vol, a2.Book_Name,a2.Date_Quantity, a3.Date_Borrow, 
                                    a5.Fine_Price, a4.Borrow_Id
                                    from book_detail a1, book a2 ,borrow a3, borrow_detail a4, fine a5
                                    where a1.Book_No=a2.Book_No and a3.Borrow_Id=a4.Borrow_Id
                                    and a1.Book_Id=a4.Book_Id and a4.Borrow_Status ='No'
                                    and a2.Fine_Id=a5.Fine_Id
                                    and a1.Book_Id='$bookid[$i]'";
                                $result=  mysqli_query($conn, $sql);
                                $array = mysqli_fetch_array($result);
                               
                                
                                
				$sql = "update borrow_detail set Borrow_Status = 'Yes'
					where Book_Id = '{$bookid[$i]}' and Borrow_Id = '{$array['Borrow_Id']}'";
				$result = mysqli_query($conn,$sql);
			
			}
                       
			$_SESSION["massageEditbook"] = "success";
                        header("location:../return.php?page=return");
			
}
?>
</body>
</html>
