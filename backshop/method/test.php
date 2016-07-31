<?php
    session_start();
    
    if(!isset($_SESSION['UserID'])){
        header("location:login.php");
        exit();
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<link href="../../css/bootstrap.css" rel="stylesheet" type="text/css" />
<script src="../../js/jquery-2.1.3.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>


</head>

<body>
<?php

?>
    
        
<div class="row"> <!--menu Left-->
    <div class="span6">	
        <div class="well">
            <?php
include 'fnc_chanceYear.php';
                include("configDB.php"); //connect DB


           if(isset($_GET['re'])){
                $sql="select b.Book_Id,a.ISBN,a.Book_Name,b.Vol,c.Category_Name,
                      a.Rent_Price,d.Fine_Price,a.Press,a.Date_Quantity,b.Book_Indate
                      from book a, book_detail b, category_book c,fine d
                      where a.Book_No=b.Book_No 
                      and a.Category_Id=c.Category_Id
                      and a.Fine_Id=d.Fine_Id
                      and b.Book_Id='{$_GET['re']}'";
                $result = mysqli_query($conn,$sql);
                $array=  mysqli_fetch_array($result);
                $tempDate=changeDate($array['Book_Indate']);
                
                $sql="select c.Book_Id, a.Author
                     from author a, book b, book_detail c
                     where a.Book_No=b.Book_No
                     and b.Book_No=c.Book_No
                     and c.Book_Id='{$_GET['re']}'";
                $result = mysqli_query($conn,$sql);
                      
echo <<<HTMLBLOCK
          <form class="form-horizontal">
        <div class="control-group">
          <label class="control-label" for="inputEmail">รหัสหนังสือ</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$array['Book_Id']}">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">ISBN</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$array['ISBN']}">
          </div>
        </div>
            <div class="control-group">
          <label class="control-label" for="inputEmail">ชื่อหนังสือ</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$array['Book_Name']}">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">เล่มที่</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$array['Vol']}">
          </div>
        </div>
            <div class="control-group">
          <label class="control-label" for="inputEmail">หมวดหมู่</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$array['Category_Name']}">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">ค่าเช่า</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$array['Rent_Price']} บาท">
          </div>
        </div>
            <div class="control-group">
          <label class="control-label" for="inputEmail">ค่าปรับ</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$array['Fine_Price']} บาท">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">สำนักพิมพ์</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$array['Press']}">
          </div>
        </div>
            <div class="control-group">
          <label class="control-label" for="inputEmail">วันที่ยืมได้</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$array['Date_Quantity']} วัน">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">วันที่หนังสือเข้าร้าน</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$tempDate}">
          </div>
        </div>
            

HTMLBLOCK;
            while ($array2=mysqli_fetch_array($result)){
                echo <<<HTMLBLOCK
                <div class="control-group">
                    <label class="control-label" for="inputPassword">ชื่อผู้แต่ง</label>
                    <div class="controls">
                      <input type="text" id="inputEmail" value="{$array2['Author']}">
                    </div>
                  </div>
HTMLBLOCK;
            }
           }
           ?>
            </form>
        </<div>
    </div>
</<div>

</body>
</html>
