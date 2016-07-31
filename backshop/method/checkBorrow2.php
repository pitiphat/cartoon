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
if(empty($_POST['proid'])){
    $_POST['proid']="000";
}
    
		include("configDB.php"); //connect DB
		if(isset($_POST["proCal"])) {
			//-------------------------------------------- คำนวนราคารวม
			$rentPrice=array();
			$status=array();
			$totalPrice=0;
			
		/*	foreach ($_POST['rentPrice'] as $temp) { //อ่านราคาแต่ละแถว

				$rentPrice[]=$temp;
				$totalPrice += $temp;
			}
		*/	
			if(isset($_POST["proChoose"])) { //มีการเลือก check box ให้คำนวนราคารวมใหม่
                            $totalPrice=0;
                            foreach ($_POST['proChoose'] as $temp){

                                if($temp != ""){ // check box มีค่า value

                                    $totalPrice+=$temp;

                                }								
                            }
			}
			
			
			//--------------------------------------------------------------

			$sql = 'select max(Borrow_Id)+1 as newBorrowId from Borrow';
			$result = mysqli_query($conn,$sql); 
			$load_Id = mysqli_fetch_array($result);
			
			if($load_Id['newBorrowId']==NULL){ 
				$newBorrowId = '00000001';
			}
			else{ 
				$newBorrowId = sprintf('%08s',$load_Id['newBorrowId']); 
			}
			
			$dayNow = date("d");
			$mountNow = date("m");
			$yearNow = date("Y");
			$today = "$yearNow-$mountNow-$dayNow";
			
			$sql = "insert into Borrow (Borrow_Id, Date_Borrow, Total_Price, Mem_Id, Promotion_Id,Emp_Id) 
				values('$newBorrowId', '$today', '$totalPrice', '{$_POST['memid']}',
				'{$_POST['proid']}','{$_SESSION['UserID']}')";
					
			$result = mysqli_query($conn,$sql);
//-------------------------------------------------------------

//-------------------------------------- คิดราคาในละเล่มว่า เล่มไหนสียเงิน เล่มไหนฟรี
			$bookID=array();
			$rent;
			foreach ($_POST['bookId'] as $temp) {

                            $bookID[]=$temp;
			}
			for($i=0; $i < count($bookID); $i++) {
				if(isset($_POST['proChoose'][$i])){ // checkbox ถูกเลือก เล่มนั้น เสียเงิน
					$rent=$_POST['proChoose'][$i];
				}
				else{ // ไม่ถูกเลือก เล่มนั้น ฟรี
					$rent=0;
				}
				$sql = "insert into Borrow_Detail (Borrow_Id, Book_Id, Rent, Borrow_Status) 
					values('$newBorrowId', '{$bookID[$i]}', $rent, 'No')";	
				$result = mysqli_query($conn,$sql);
				
				$sql = "update book_detail set Book_Status = 'False'
					where Book_Id = '{$bookID[$i]}'";
				$result = mysqli_query($conn,$sql);
			}
			
                        $_SESSION["massageEditbook"] = "success";
			header("location:../index.php?page=borrow");
		}
mysqli_close($conn);
?>
</body>
</html>
