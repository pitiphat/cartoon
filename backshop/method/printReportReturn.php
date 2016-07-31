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


    $sql = "select a.Return_Id, d.Book_Name, c.Vol, a.D_Return, f.Emp_Name, f.Emp_Lastname 
            from return_book a, book_detail c, book d, return_detail e,employee f 
            WHERE e.Book_Id=c.Book_Id 
            and c.Book_No=d.Book_No 
            and a.Return_Id=e.Return_Id 
            and a.Emp_Id=f.Emp_Id
            and a.D_Return BETWEEN '$startReport' AND '$endReport'";

    $result = mysqli_query($conn,$sql);
    

?>
    

  
<?php

if(mysqli_num_rows($result)>0){
echo<<<HTMLBLOCK
                        <br>
                        <H4 class="text-center">รายงานการคืนหนังสือ</h4> <br>
                        <H4 class="text-center">(วันที่ {$_POST['date0']} ถึง {$_POST['date1']})</h4>
			<table class="table table-hover">
			<tr><th>รหัสการคืน</th><th>ชื่อหนังสือ</th><th>เล่มที่</th><th>วันที่คืน</th>
			<th>ชื่อพนักงาน</th><th>นามสกุลพนักงาน</th></tr>
HTMLBLOCK;
			while($array=mysqli_fetch_array($result)){
                            $tempDate=changeDate($array['D_Return']);
				echo <<<HTMLBLOCK
				<tr>
				<td>{$array['Return_Id']}</td>
				<td>{$array['Book_Name']}</td>
				<td>{$array['Vol']}</td>
				<td>{$tempDate}</td>
				<td>{$array['Emp_Name']}</td>
                                <td>{$array['Emp_Lastname']}</td></tr>
				
HTMLBLOCK;
			}
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
