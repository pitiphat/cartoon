<?php
 
    session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="../../js/jquery-2.1.3.min.js"></script>

</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<title>Untitled Document</title>


<script>

$(document).ready(function(){
	recalculate();
	count_checkbox();

		$("input[type=checkbox]").change(function(){
			recalculate();
			count_checkbox();
		});
				
				
		function recalculate(){
			var sum = 0;
			$("input[type=checkbox]:checked").each(function(){
                            sum += parseInt($(this).attr("value"));
			});
			$("#output").html(sum);
			
		}
		
		function count_checkbox(){
			
			var count = $("input[type=checkbox]").size()
			var limit = count - $("#dis").val()
			
			
			if ($("input[type=checkbox]:checked").size() != limit){
				$("button").prop("disabled",true);
			}
			else{	
                                var price = $("#output").text()
                                var pay = $("#pay").val()
                                var change = pay - price;
                                if(change >= 0){
                                    $("#change").val(change);
                                   $("button").prop("disabled",false);
                                }
                     
			}
		}
			
			//----------------คิดเงินทอน
		$("#pay").keyup(function(){
                    
			var price = $("#output").text()
			var pay = $("#pay").val()
			var change = pay - price;
                        if(change >= 0){
                            $("#change").val(change);
                            var count = $("input[type=checkbox]").size()
                            var limit = count - $("#dis").val()
                            if ($("input[type=checkbox]:checked").size() != limit){
				$("button").prop("disabled",true);//
                            }
                            else{
                                $("button").prop("disabled",false);
                            }
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
		if(isset($_POST["btnCheckBorrow"])) {
			
			$sql = "select * from member where Mem_Id='{$_POST['memId']}'";
			$result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)==0){
				echo"ไม่พบสมาชิก";
				exit();
			}
			
			
			$sql = "select d1.Borrow_Id, d3.Mem_Name, d3.Mem_Lastname, d5.Book_Name,
                                d1.Borrow_Status, d4.Vol, d4.Book_Id, d2.Date_Borrow
                                from borrow_detail d1,borrow d2, member d3,book_detail d4, book d5
                                where d1.Borrow_Id=d2.Borrow_Id 
                                and d4.Book_Id=d1.Book_Id 
                                and d2.Mem_Id=d3.Mem_Id 
                                and d5.Book_No= d4.Book_No 
                                and d1.Borrow_Status='No'
                                and d4.Book_Status='False'
                                and d3.Mem_Id='{$_POST['memId']}'";
					
			$result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0){
				echo "<br>";
				echo"มีหนังสือที่ยังไม่ได้คืน";
				ShowBook_NotReturn($result);
				exit();
			}
			else{
                            echo "<br>";
                            $check = check_Book();

                                if($check=="true"){
                                    ShowBook_Borrow();
                                }

                                else{
                                    $_SESSION["massageEditbook"][] = "เกิดข้อผิดพลาด รหัสหนังสือไม่ถูกต้อง หรือหนังสือถูกยืมไปแล้ว";
                                    header("location:../borrow.php?page=borrow");
                                    exit();
                                }
			}
	
		}

		
		
		
/*--------------------------------------------------------------
		ฟังก์ชั่น แสดงหนังสือที่ยังไม่ได้คืน
---------------------------------------------------------------*/
function ShowBook_NotReturn($result){
    
    include 'fnc_chanceYear.php';
    $i=1;
			echo <<<HTMLBLOCK
			<table class="table table-hover">
			<tr><th>ลำดับที่</th><th>รหัสสมาชิก</th><th>ชื่อ</th><th>นามสกุล</th><th>รหัสหนังสือ</th>
			<th>ชื่อเรื่อง</th><th>เล่มที่</th><th>วันที่ยืม</th><th>สถานะ</th></tr>
HTMLBLOCK;
			while($array=mysqli_fetch_array($result)){
                            $tempDate=changeDate($array['Date_Borrow']);
				echo <<<HTMLBLOCK
				<tr class='error'>
                                <td>$i</td>
                                <td>{$array['Borrow_Id']}</td>
				<td>{$array['Mem_Name']}</td>
				<td>{$array['Mem_Lastname']}</td>
				<td>{$array['Book_Id']}</td>
				<td>{$array['Book_Name']}</td>
				<td>{$array['Vol']}</td>
				<td>{$tempDate}</td>
				<td>ยังไม่คืน</td></tr>
				
HTMLBLOCK;
                                $i++;
			}
			echo "</table>";
}
		
/*--------------------------------------------------------------
				ฟังก์ชั่น สร้างข้อมูลหนังสือที่ลูกค้ายืม แสดงเป็นตาราง
---------------------------------------------------------------*/	

function ShowBook_Borrow(){
	include("configDB.php");
        //include 'fnc_chanceYear.php';
	$countBook=0;
	$totalPrice=0;
	$pro=NULL;
	$proId=NULL;
	$proValue=0;
	//---------- เช็คว่าเช่ากี่เล่ม เข้าโปรไหน -----------
        $resultUnique = array_unique($_POST['field']);
	$checked_arr = $resultUnique;
	$count = count($checked_arr);
	$sql = "select * from promotion where Pro_Status='Open'
			and $count >= Pro_Borrow
			ORDER BY Pro_Borrow DESC";
	$result = mysqli_query($conn,$sql);
	$arr = mysqli_fetch_array($result);

	$proId=$arr['Promotion_Id']; //$proId คือ รหัสโปรโมชัน
	$proValue=$arr['Discount'];	 //$proValue คือ เล่มที่ได้ฟรี
	//---------------------------------------------------------------------
	
	
	$i=0; //ใช้เพื่อตั้งชื่อ name ของ checkbox คือ proChoose[$i]
        $j=1;
	echo <<<HTMLBLOCK
	<form action="checkBorrow2.php" method="POST">
	<table class="table table-hover">
	<tr><th>ลำดับที่</th><th>รหัสหนังสือ</th><th>ชื่อหนังสือ</th><th>เล่มที่</th><th>ค่าเช่า</th><th>จำนวนวัน</th><th>เล่มที่คิดเงิน</th></tr>
HTMLBLOCK;
        $resultUnique = array_unique($_POST['field']);
	foreach ($resultUnique as $book){ //วนอ่านรหัสหนังสือ จากการ submit form หน้า Borrow.php
                $sql = "select * from book d1, book_detail d2
                        where d2.Book_Id='$book' and d1.Book_No=d2.Book_No";

                $result = mysqli_query($conn,$sql);
                $dataLoad = mysqli_fetch_array($result);
                $totalPrice += $dataLoad['Rent_Price'];
                echo <<<HTMLBLOCK
                <tr class='info'>
                        <td><input type="text" value="$j" style="width:40px"readonly></td>
                        <td><input type="text" name="bookId[]" value="{$dataLoad['Book_Id']}" style="width:80px"readonly></td>
                        <td><input type="text" name="bookName[]" value="{$dataLoad['Book_Name']}" style="width:200px"readonly></td>
                        <td><input type="text" name="vol[]"  value="{$dataLoad['Vol']}" style="width:100px"readonly></td>
                        <td><input type="text" name="rentPrice[]" value="{$dataLoad['Rent_Price']}" style="width:100px"readonly></td>
                        <td><input type="text" name="date[]" value="{$dataLoad['Date_Quantity']}" style="width:100px"readonly></td>
                        <td><input name="proChoose[$i]" class="test" type="checkbox" value="{$dataLoad['Rent_Price']}"
                                checked="checked">เลือก</td>

                </tr>
                <input name="memid" type="hidden" value="{$_POST['memId']}">
                <input name="proid" type="hidden" value="{$proId}">
                <input name="dis" id="dis" type="hidden" value="{$proValue}">
HTMLBLOCK;
                $i++;
                $j++;
	} // จบ for each
	echo <<<HTMLBLOCK
</table>
<table>
  <tr>
    <td><button type="submit" name="proCal" class="btn btn-warning" disabled/>ยืนยัน</button></td>
    <td><h5>จำนวนเล่มที่ได้ฟรี : {$proValue} เล่ม</h5></td>
  </tr>
</table>

</form>

<table class="table table-hover">
  <tr>
    <td style="width:20%"><h3>ราคารวม</h3></td>
    <td style="width:20%"><h3 id="output"></h3></td>
    <td style="width:10%"><h3>บาท</h3></td>
  </tr>
  <tr>
	  <td>รับเงิน</td>
	  <td><input name="pay" type="text" id="pay" style="width:100px"/> บาท</td>
	  <td>ทอนเงิน</td>
	  <td><input name="change" type="text" id="change" style="width:100px" readonly/>บาท</td>
  </tr>
 
</table>

		
HTMLBLOCK;
	
}

/*--------------------------------------------------------------
				ฟังก์ชั่น ตรวจสอบว่า กรอกรหัสหนังสือมาตรงการ DB หรือไม่ และ หนังสือต้องมีสถานะว่าง
---------------------------------------------------------------*/

function check_Book(){
	include("configDB.php"); //connect DB
	foreach ($_POST['field'] as $book){
		$sql="select * from book_detail where Book_Id='$book' and Book_Status ='True'";
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

mysqli_close($conn);
?>


</div>


</body>
</html>
