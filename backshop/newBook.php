<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

    session_start();               

        
        
if(!isset($_SESSION['UserID'])){
    header("location:login.php");
    exit();	
}
?>
<title>Untitled Document</title>
<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery-2.1.3.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</head>

<body>

<div class="container">   
<?php

include 'header.php';
include 'menu.php';
include 'method/fnc_chanceYear.php';
?>
 <div class="span9">
        <div class="well">
<?php
if($_SESSION["UserLV"]!="99"){
           echo '<div class="alert alert-error">
               คุณไม่มีสิทธิใช้งานเมนูนี้
            </div>';
           exit();
}
if(isset($_SESSION['massageEditbook']))
    {  
        if($_SESSION['massageEditbook'] == "success")
        {echo'   <div class="alert alert-success">';
            echo '<button type="button" class="close" data-dismiss="alert"> &times </button>';
            echo "{$_SESSION['massageEditbook']}";
            echo '</div>';
            unset($_SESSION["massageEditbook"]);
        }
        else{
            
            echo'   <div class="alert alert-error">';
            echo '<button type="button" class="close" data-dismiss="alert"> &times </button>';
            
            foreach($_SESSION['massageEditbook'] as $e){
               echo "$e <br>";
                
            }
            
            echo '</div>';
            unset($_SESSION["massageEditbook"]);
        }
    }
     
    include("method/configDB.php"); //connect DB
		
    $sql = 'select max(Book_Id)+1 as nextBookId from book_detail';
    $result = mysqli_query($conn,$sql); 
    $load_Id = mysqli_fetch_array($result);

    if($load_Id['nextBookId']==null){ 
            $newBookId = '00000001'; 
    }
    else{ 
            $newBookId = sprintf('%08s',$load_Id['nextBookId']); 
    }
    //ชื่อเรื่อง
    $sql = "select * from book where Title_Status='Open'
            order by Book_Name asc";
    $result = mysqli_query($conn,$sql); 
    $htmlBookName = '<select name="bookName">';
    while($array=mysqli_fetch_array($result)){
            $htmlBookName .= "<option value=\"{$array['Book_No']}\">{$array['Book_Name']}</option>";
    }
    $htmlBookName .= '</select>';


    $dayNow = date("d");
    $mountNow = date("m");
    $yearNow = date("Y");
    $today = "$yearNow-$mountNow-$dayNow";
    $tempDate=changeDate($today);
?>


<form class="form-horizontal" name="form1" method="post" action="method/mNewBook.php">
  <div class="control-group">
    <label class="control-label" for="inputEmail">รหัสหนังสือ</label>
    <div class="controls">
      <input name="bookId" type="text" value="<?php echo $newBookId;?>"readonly/>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">ชื่อเรื่อง <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
      <?php echo $htmlBookName; ?>
    </div>
  </div>
   <div class="control-group">
    <label class="control-label" for="inputPassword">วันที่หนังสือเข้าร้าน</label>
    <div class="controls">
      <input name="bookIndate" type="text" value="<?php echo $tempDate;?>"readonly/>
    </div>
  </div>
   <div class="control-group">
    <label class="control-label" for="inputPassword">เล่มที่ <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
      <input name="vol" type="text" required/>
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <button type="submit" name="addNewBook" class="btn btn-warning">ยืนยัน</button>
    </div>
  </div>
    
</form>
    
    
    </<div>
    </div>
</div>
</div>

</body>
</html>
