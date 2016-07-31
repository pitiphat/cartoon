<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<link href="../../css/bootstrap.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">   
<?php
include 'fnc_chanceYear.php';

$startReport="{$_POST['date0']}";
$endReport="{$_POST['date1']}";

$show=explode("/",$startReport);
$show[2]-=543;
$startReport="$show[2]-$show[1]-$show[0]";

//------------------------------------------------

$show2=explode("/",$endReport);
$show2[2]-=543;
$endReport="$show2[2]-$show2[1]-$show2[0]";



    include("configDB.php");


    $sql = "select d.Book_Id, c.Book_Name, d.Vol, a.Date_Borrow, b.Rent
            from borrow a, borrow_detail b, book c, book_detail d
            where a.Borrow_Id=b.Borrow_Id
            and b.Book_Id=d.Book_Id
            and c.Book_No=d.Book_No
            and b.Rent >0
            and Date_Borrow BETWEEN '$startReport' AND '$endReport'
            ORDER BY b.Rent desc";     
    $result = mysqli_query($conn,$sql);
    
    $sql = "select SUM(Total_Price) as sum_total
            from borrow
            where Date_Borrow BETWEEN '$startReport' AND '$endReport'";
    $result2 = mysqli_query($conn,$sql);
    $array2=mysqli_fetch_array($result2);
    

?>
    

  
<?php

if(mysqli_num_rows($result)>0){
echo<<<HTMLBLOCK
                        <br>
                        <H4 class="text-center">รายงานรายได้จากการยืมหนังสือ</h4> <br>
                        <H4 class="text-center">(วันที่ {$_POST['date0']} ถึง {$_POST['date1']})</h4>
			<table class="table table-hover">
			<tr><th>รหัสหนังสือ</th><th>ชื่อหนังสือ</th><th>เล่มที่</th><th>วันที่ยืม</th><th>ค่าเช่า / บาท</th></tr>
HTMLBLOCK;
			while($array=mysqli_fetch_array($result)){
                            $tempDate=changeDate($array['Date_Borrow']);
				echo <<<HTMLBLOCK
				<tr>
				<td>{$array['Book_Id']}</td>
				<td>{$array['Book_Name']}</td>
				<td>{$array['Vol']}</td>
                                <td>{$tempDate}</td>
                                <td>{$array['Rent']}</td>
				</tr>
				
HTMLBLOCK;
			}
                        echo"<tr><td colspan=5> <H4 class='text-right'>รวม {$array2['sum_total']} บาท<h4/></td></tr>";
			echo "</table>";
                        
}
else{
echo<<<HTMLBLOCK
    <br>
<div class="row">
      <div class="span8 offset2">
            <div class="alert alert-error">
                <H4 class="text-center">ไม่สามารถออกรายงานได้เนื่องจาก ไม่พบข้อมูล</H4>
                    
            </div>
      </div>
</div>
    <div class="row">
      <div class="span8 offset2">
            
                <img src="../../img/350_4466.jpg" class="img-circle">
            
      </div>
</div>
HTMLBLOCK;
 
}
?>
</body>
</html>
