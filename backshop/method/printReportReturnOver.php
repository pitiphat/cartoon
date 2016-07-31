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

$dayNow = date("d");
	$mountNow = date("m");
	$yearNow = date("Y");
	$today = "$yearNow-$mountNow-$dayNow";

		include("configDB.php");


    $sql = "select b.Book_Id, c.Book_Name, d.Vol, a.Date_Borrow, c.Date_Quantity
            from borrow a, borrow_detail b, book c, book_detail d
            where a.Borrow_Id=b.Borrow_Id 
            and b.Book_Id=d.Book_Id
            and c.Book_No=d.Book_No
            and b.Borrow_Status ='No'
            and a.Date_Borrow BETWEEN '$startReport' AND '$endReport'";
    $result = mysqli_query($conn,$sql);
    

?>
    

  
<?php

if(mysqli_num_rows($result)>0){
$rows=0;

                        $html ="<br>
                        <H4 class='text-center'>รายงานการยืมหนังสือเกินกำหนด</h4> <br>
                        <H4 class='text-center'>(วันที่ {$_POST['date0']} ถึง {$_POST['date1']})</h4>
			<table class='table table-hover'>
			<tr><th>รหัสหนังสือ</th><th>ชื่อหนังสือ</th><th>เล่มที่</th><th>วันที่มายืม</th>
			<th>จำนวนวันที่ยืมได้</th><th>จำนวนวันที่เกิน</th><th>สถานะ</th></tr>";

			while($array=mysqli_fetch_array($result)){
                            $tempDate=changeDate($array['Date_Borrow']);
                            $Date  = DateDiff("{$array['Date_Borrow']}","$today","{$array['Date_Quantity']}");
                            if($Date > 0){
                                
				$html = $html ."<tr><td>{$array['Book_Id']}</td>";
				$html = $html ."<td>{$array['Book_Name']}</td>";
                                $html = $html ."<td>{$array['Vol']}</td>";
				$html = $html ."<td>{$tempDate}</td>";
                                $html = $html ."<td>{$array['Date_Quantity']}</td>";
                                $html = $html ."<td>$Date</td>";
                                $html = $html ."<td>ยังไม่คืน</td></tr>";
                            }
                            else{
                                $rows+=1;
                                continue;
                            }
			}
			$html = $html ."</table>";
                        
                        //--------------------------------------------------------------------------------
                        
                        
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
 exit();
}

if(mysqli_num_rows($result)==$rows){
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
else{
    echo $html;
}
?>
</body>
</html>

<?php
function DateDiff($strDate1,$strDate2,$strDateQuantity){
        $temp=$strDateQuantity*86400;
	return (strtotime($strDate2) - (strtotime($strDate1)+$temp))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24

}
?>