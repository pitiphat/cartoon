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

    
    //-------------------------------------------------------------------- 1
    $sql = "select d.Book_Id, c.Book_Name, d.Vol, a.Date_Borrow, b.Rent
            from borrow a, borrow_detail b, book c, book_detail d
            where a.Borrow_Id=b.Borrow_Id
            and b.Book_Id=d.Book_Id
            and c.Book_No=d.Book_No
            and b.Rent >0
            and Date_Borrow BETWEEN '$startReport' AND '$endReport'
            ORDER BY b.Rent desc";     
    $resultRent = mysqli_query($conn,$sql);
    
    $sql = "select SUM(Total_Price) as sum_total
            from borrow
            where Date_Borrow BETWEEN '$startReport' AND '$endReport'";
    $result2 = mysqli_query($conn,$sql);
    $array2=mysqli_fetch_array($result2);
    
    if(mysqli_num_rows($resultRent)>0){
echo<<<HTMLBLOCK
                        <br>
                        <H4 class="text-center">รายงานรายได้จากการยืมหนังสือ</h4> <br>
                        <H4 class="text-center">(วันที่ {$_POST['date0']} ถึง {$_POST['date1']})</h4>
			<table class="table table-hover">
			<tr><th>รหัสหนังสือ</th><th>ชื่อหนังสือ</th><th>เล่มที่</th><th>วันที่ยืม</th><th>ค่าเช่า / บาท</th></tr>
HTMLBLOCK;
			while($array=mysqli_fetch_array($resultRent)){
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
                        //echo"<tr><td colspan=5> <H4 class='text-right'>รวม {$array2['sum_total']} บาท<h4/></td></tr>";
			echo "</table>";
                        
}
else{
/*echo<<<HTMLBLOCK
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
 exit();
 
 */
}
//------------------------------------------------------------------------- 2

$sql = "select b.Book_Id, c.Book_Name, b.Vol, d.D_Return, a.Fine
            from return_detail a, book_detail b, book c, return_book d 
            where a.Book_Id=b.Book_Id 
            and b.Book_No=c.Book_No 
            and a.Return_Id=d.Return_Id 
            and D_Return BETWEEN '$startReport' AND '$endReport'
            AND '2015-05-20' and a.Fine >0 
            ORDER BY a.Fine desc";
    $resultFine = mysqli_query($conn,$sql);
    
    $sql = "select SUM(Total_Fine) as sum_total
            from return_book
            where D_Return BETWEEN '$startReport' AND '$endReport'";
    $result2 = mysqli_query($conn,$sql);
    $array2=mysqli_fetch_array($result2);
    

?>
    

  
<?php

if(mysqli_num_rows($resultFine)>0){
echo<<<HTMLBLOCK
                        <br>
                        <H4 class="text-center">รายงานรายได้จากการคืนหนังสือ</h4> <br>
                        <H4 class="text-center">(วันที่ {$_POST['date0']} ถึง {$_POST['date1']})</h4>
			<table class="table table-hover">
			<tr><th>รหัสหนังสือ</th><th>ชื่อหนังสือ</th><th>เล่มที่</th><th>วันที่คืน</th><th>ค่าปรับ / บาท</th></tr>
HTMLBLOCK;
			while($array=mysqli_fetch_array($resultFine)){
                            $tempDate=changeDate($array['D_Return']);
				echo <<<HTMLBLOCK
				<tr>
				<td>{$array['Book_Id']}</td>
				<td>{$array['Book_Name']}</td>
				<td>{$array['Vol']}</td>
                                <td>{$tempDate}</td>
                                <td>{$array['Fine']}</td>
				</tr>
				
HTMLBLOCK;
			}
                        //echo"<tr><td colspan=5> <H4 class='text-right'>รวม {$array2['sum_total']} บาท<h4/></td></tr>";
			echo "</table>";
                        
}
//-------------------------------------------------------------------------
if(mysqli_num_rows($resultRent)==0 && mysqli_num_rows($resultFine)==0){
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
 exit();
}



//------------------------------------------------------------------------- 3
    $sql = "select SUM(Total_Price) as sum_total
            from borrow
            where Date_Borrow BETWEEN '$startReport' AND '$endReport'";
    $result = mysqli_query($conn,$sql);
    
    $sql = "select SUM(Total_Fine) as sum_fine 
            from return_book 
            where D_Return BETWEEN '$startReport' AND '$endReport'";
    $result2 = mysqli_query($conn,$sql);
    
    $array=mysqli_fetch_array($result);
    $array2=mysqli_fetch_array($result2);
    $allTotal=$array['sum_total']+$array2['sum_fine'];
    
    if(is_null($array['sum_total'])){
        $array['sum_total']=0;
    }
    if(is_null($array2['sum_fine'])){
        $array2['sum_fine']=0;
    }

?>
    

  
<?php

if(mysqli_num_rows($result)>0){
echo<<<HTMLBLOCK
                        <br>
			<table align="right">
			<tr>
                            <td> <H4>รายได้จากการยืม</td>
                            <td width="30%" align="center"><h4>{$array['sum_total']}</h4></td> 
                            <td><h4>บาท</h4></td>
                        </tr>
                            
                        <tr>
                            <td> <H4>รายได้จากการคืน</h4></td>
                            <td width="30%" align="center"><h4>{$array2['sum_fine']}</h4></td> 
                            <td><h4>บาท</h4></td>
                        </tr>
                        <tr>
                            <td> <H4>รวม</h4></td>
                            <td width="30%" align="center"><h4>{$allTotal}</h4></td> 
                            <td><h4>บาท</h4></td>
                        </tr>
				
HTMLBLOCK;
			
			echo "</table>";
                        
}

?>
</body>
</html>
