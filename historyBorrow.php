<?php

    session_start(); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<div class="container">   
<?php
include 'header.php';
include 'menu.php';


?>
 <div class="span9">
        <div class="well">
    
<?php
if(isset($_SESSION['MemberUserID'])){
	include("backshop/method/configDB.php");
	
       
			$sql = "select d5.Book_Name,
                                d4.Vol, d4.Book_Id, d2.Date_Borrow, d6.Fine_Price, d5.Date_Quantity
                                from borrow_detail d1,borrow d2, member d3,book_detail d4, book d5, fine d6
                                where d1.Borrow_Id=d2.Borrow_Id and d4.Book_Id=d1.Book_Id 
                                and d2.Mem_Id=d3.Mem_Id and d5.Book_No= d4.Book_No and d1.Borrow_Status='No'
                                and d5.Fine_Id=d6.Fine_Id
                                and d3.Mem_Id='{$_SESSION['MemberUserID']}'";
					
			$result = mysqli_query($conn,$sql);
			if(mysqli_num_rows($result)>0){
				echo "<br>";
				echo"มีหนังสือที่ยังไม่ได้คืน";
				ShowBook_NotReturn($result);
				exit();
			}
                        else{
                            echo'
                                <div class="alert alert-error">
                                        ไม่มีรายการหนังสือที่ต้องคืน
                                </div>';
                        }
}
else{
	echo'
	<div class="alert alert-error">
		คุณยังไม่ได้เข้าสู่ระบบ

	</div>';
}

function ShowBook_NotReturn($result){
    
    include 'backshop/method/fnc_chanceYear.php';
    
	$dayNow = date("d");
	$mountNow = date("m");
	$yearNow = date("Y");
	$today = "$yearNow-$mountNow-$dayNow";
	
                echo <<<HTMLBLOCK
                <table class="table table-hover">
                <tr><th>รหัสหนังสือ</th>
                <th>ชื่อเรื่อง</th><th>เล่มที่</th><th>วันที่ยืม</th><th>วันที่ต้องคืน</th><th>ค่าปรับ</th><th>สถานะ</th></tr>
HTMLBLOCK;
			while($array=mysqli_fetch_array($result)){
                            
                             $tempDate=changeDate($array['Date_Borrow']);
                            
				$fine=0;
				$Date  = DateDiff("{$array['Date_Borrow']}","$today","{$array['Date_Quantity']}");
                                $Date2  = DateDiff2("{$array['Date_Borrow']}","{$array['Date_Quantity']}");
                                
                                $tempDate2=changeDate($Date2);
				
				if($Date > 0){
					$fine = $array['Fine_Price']* $Date;
				}
				
					echo <<<HTMLBLOCK
					<tr class='error'>
					<td>{$array['Book_Id']}</td>
					<td>{$array['Book_Name']}</td>
					<td>{$array['Vol']}</td>
					<td>{$tempDate}</td>
                                        <td>{$tempDate2}</td>
					<td>{$fine}</td>
					<td>ยังไม่คืน</td></tr>
				
HTMLBLOCK;
			}
			echo "</table>";
}

function DateDiff($strDate1,$strDate2,$strDateQuantity){
        $temp=$strDateQuantity*86400;
	return (strtotime($strDate2) - (strtotime($strDate1)+$temp))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24

}
function DateDiff2($strDate1,$strDateQuantity){
        $temp=$strDateQuantity*86400;
	 $dateReturn =(strtotime($strDate1) + $temp);  // 1 day = 60*60*24
         return date("Y-m-d", $dateReturn);
}
?>
            </<div>
    </div>
</div>
</div>
</body>
</html>
