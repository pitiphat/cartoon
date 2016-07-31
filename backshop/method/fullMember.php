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
    
        
<div class="row"> <!--menu Left-->
    <div class="span6">	
        <div class="well">
            <?php

                include("configDB.php"); //connect DB


           if(isset($_GET['re'])){
                $sql="select * from member
                      where Mem_Id='{$_GET['re']}'";
                $result = mysqli_query($conn,$sql);
                $array=  mysqli_fetch_array($result);
                      
echo <<<HTMLBLOCK
          <form class="form-horizontal">
        <div class="control-group">
          <label class="control-label" for="inputEmail">รหัสสมาชิก</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$array['Mem_Id']}">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">ชื่อสมาชิก</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$array['Mem_Name']}">
          </div>
        </div>
            <div class="control-group">
          <label class="control-label" for="inputEmail">นามสกุล</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$array['Mem_Lastname']}">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">ชื่อในระบบ</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$array['Mem_User']}">
          </div>
        </div>
            <div class="control-group">
          <label class="control-label" for="inputEmail">รหัสผ่าน</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$array['Mem_Pass']}">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">เพศ</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$array['Gender']}">
          </div>
        </div>
            <div class="control-group">
          <label class="control-label" for="inputEmail">ที่อยู่</label>
          <div class="controls">
            <textarea rows="4" cols="50">{$array['Address']}</textarea>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">เบอร์โทร</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$array['Tel']}">
          </div>
        </div>
            <div class="control-group">
          <label class="control-label" for="inputEmail">รหัสบัตรประจำตัวประชาชน</label>
          <div class="controls">
            <input type="text" id="inputEmail" value="{$array['Id_Card']}">
          </div>
        </div>
            </form>

HTMLBLOCK;
           
        }
           ?>
           
        </<div>
    </div>
</<div>

</body>
</html>
