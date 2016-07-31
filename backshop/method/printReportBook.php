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


    $sql = "select b.Book_Id, a.ISBN,a.Book_Name,b.Vol, b.Book_Status, b.Book_Indate
            from book a, book_detail b
            WHERE 
            a.Book_No=b.Book_No
            and b.Book_Indate BETWEEN '$startReport' AND '$endReport'";
    $result = mysqli_query($conn,$sql);
    
    $sql = "select COUNT(*) as Count_Book
            from book_detail
            WHERE 
            Book_Indate BETWEEN '$startReport' AND '$endReport'";
    $result2 = mysqli_query($conn,$sql);
    $array2=mysqli_fetch_array($result2);
    $showCountBook="<H4>จำนวน {$array2['Count_Book']}</H4>";
    

?>
    

  
<?php

if(mysqli_num_rows($result)>0){
echo<<<HTMLBLOCK
                        <br>
                        <H4 class="text-center">รายงานหนังสือในร้าน</h4> <br>
                        <H4 class="text-center">(วันที่ {$_POST['date0']} ถึง {$_POST['date1']})</h4>
			<table class="table table-hover">
			<tr><th>รหัสหนังสือ</th><th>ISBN</th><th>ชื่อหนังสือ</th><th>เล่มที่</th><th>วันที่</th>
			</tr>
HTMLBLOCK;
			while($array=mysqli_fetch_array($result)){
                            $tempDate=changeDate($array['Book_Indate']);
				echo <<<HTMLBLOCK
				<tr>
				<td>{$array['Book_Id']}</td>
				<td>{$array['ISBN']}</td>
				<td>{$array['Book_Name']}</td>
				<td>{$array['Vol']}</td>
                                <td>$tempDate</td>
                                </tr>
                                
				
HTMLBLOCK;
			}
                        echo"<tr><td colspan='6'><H4>
                            <ul class='inline'>
                                <li>จำนวนหนังสือที่มี</li>
                                <li>{$array2['Count_Book']}</li>
                                <li>เล่ม</li>
                            </ul>
                            </H4>
                            </td></tr>";
			echo "</table>";
                        echo<<<HTMLBLOCK
                        

HTMLBLOCK;
                        
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
