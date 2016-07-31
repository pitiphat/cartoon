<?php

    session_start(); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../../js/jquery-2.1.3.min.js"></script>
<link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<title>Untitled Document</title>

<script>

$(document).ready(function(){
    
    if($("#output").text() == 0){
       $("button").prop("disabled",false);
    }
			
			//----------------คิดเงินทอน
		$("#pay").keyup(function(){
                    
			var price = $("#output").text()
			var pay = $("#pay").val()
			var change = pay - price;
                        
                        if(change >= 0){
                            $("#change").val(change);
                            $("button").prop("disabled",false);
                        }
                        else if(change < 0){
                            $("#change").val(" ");
                            $("button").prop("disabled",true);
                        }
                        
				
		});
		
});

</script>
</head>

<body>
<div class="container">
<?php
if(!isset($_SESSION['UserID']))
	{
		include("../login.php");
		exit();	
	}
?>
<?php
		
		include("configDB.php"); //connect DB

		if(isset($_POST["btnCheckReturn"])) {
			
			$check = check_Book();
			if($check=="true"){
				showBooks_Return();
			}
					
			else{
                            $_SESSION["massageEditbook"][] = "เกิดข้อผิดพลาด ไม่พบข้อมูลหนังสือ";
                            header("location:../return.php?page=return");
                            exit();
			}
		}
		
			
function DateDiff($strDate1,$strDate2,$strDateQuantity){
        $temp=$strDateQuantity*86400;
	return (strtotime($strDate2) - (strtotime($strDate1)+$temp))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24

}

function check_Book(){
	include("configDB.php"); //connect DB
        $resultUnique = array_unique($_POST['field']);
	foreach ($resultUnique as $book){
		$sql="select * from book_detail a, borrow_detail b
                      where a.Book_Id=b.Book_Id
                      and b.Borrow_Status = 'No'
                      and a.Book_Status ='False'
                      and a.Book_Id='$book'";
		$check="";
		
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0){
			$check ="true";
		}
		else{
			$check = "false";
			break;
		}
	}
	return $check;
}

function showBooks_Return(){
        include 'fnc_chanceYear.php';
	include("configDB.php"); //connect DB
        $i=1;
        $totalFine=0;
	$dayNow = date("d");
	$mountNow = date("m");
	$yearNow = date("Y");
	$today = "$yearNow-$mountNow-$dayNow";
	echo <<<HTMLBLOCK
		<form action="returnRecord.php" method="POST">
			<table class="table table-hover">
			<tr><th>ลำดับที่</th><th>รหัสหนังสือ</th><th>ชื่อหนังสือ</th><th>เล่มที่</th><th>วันที่มายืม</th><th>ค่าปรับ</th><th>สถานะ</th></tr>
HTMLBLOCK;
			$resultUnique = array_unique($_POST['field']);
			foreach ($resultUnique as $book){
				
				$sql = "select a1.Book_Id, a1.Vol, a2.Book_Name,a2.Date_Quantity, a3.Date_Borrow, 
						a5.Fine_Price, a4.Borrow_Id
						from book_detail a1, book a2 ,borrow a3, borrow_detail a4, fine a5
						where a1.Book_No=a2.Book_No and a3.Borrow_Id=a4.Borrow_Id
						and a1.Book_Id=a4.Book_Id and a1.Book_Status='False' and a4.Borrow_Status ='No'
						and a2.Fine_Id=a5.Fine_Id
						and a1.Book_Id='$book'";
					$result = mysqli_query($conn,$sql);
					
					if(mysqli_num_rows($result)<=0){
						exit();
					}
					
					$array=mysqli_fetch_array($result);
                                        $tempDate=changeDate($array['Date_Borrow']);
					$fine=0;
					$Date  = DateDiff("{$array['Date_Borrow']}","$today","{$array['Date_Quantity']}");
					if($Date > 0){
						$fine = $array['Fine_Price']* $Date;
					}
                                        $totalFine+=$fine;
					echo <<<HTMLBLOCK
				<tr class='error'>
                                <td>$i</td>
				<td>{$array['Book_Id']}</td>
				<td>{$array['Book_Name']}</td>
				<td>{$array['Vol']}</td>
				<td>{$tempDate}</td>
				<td>$fine</td>
				<td>ยังไม่คืน</td>
				<td><input name="bookid[]" type="hidden" value="{$array['Book_Id']}"></td>
				<td><input name="fineprice[]" type="hidden" value="{$fine}"></td>
				<td><input name="today" type="hidden" value="{$today}"></td>
				</tr>
				
HTMLBLOCK;
                                $i++;
			}
			echo <<<HTMLBLOCK
                        
                        <table class="table table-hover">
  <tr>
    <td style="width:20%"><h3>ราคารวม</h3></td>
    <td style="width:20%"><h3 id="output">{$totalFine}</h3></td>
    <td style="width:10%"><h3>บาท</h3></td>
  </tr>
  <tr>
	  <td>รับเงิน</td>
	  <td><input name="pay" type="text" id="pay" style="width:100px"/> บาท</td>
	  <td>ทอนเงิน</td>
	  <td><input name="change" type="text" id="change" style="width:100px" readonly/>บาท</td>
  </tr>
 
</table>

			</table>
			<td><input name="Borrow_Id" type="hidden" value="{$array['Borrow_Id']}"></td>
			<td><button type="submit" id="btnReturn" name="btnReturn" class="btn btn-warning" disabled/>ยืนยันการคืน</
             	 button></td>
			</form>
HTMLBLOCK;
}

?>
    
</div>
</body>
</html>
