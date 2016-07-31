<?php

    session_start(); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
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
include("backshop/method/configDB.php");
include 'searchBookResult.php';
if(isset($_GET['btn_Search'])){
                fnc_search_result();
           }
           else{
            echo <<<HTMLBLOCK
            <form class="form-horizontal" action="searchBook.php" method="GET">
                <div class="control-group">
                  <label class="control-label" for="inputEmail">ค้นหาจาก</label>
                  <div class="controls">
                    <select name="selectBook" id="select">
                      <option value="book">ชื่อหนังสือ</option>
                      <option value="category">หมวดหมู่หนังสือ</option>
                      <option value="press">สำนักพิมพ์</option>
                    </select></td>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="inputPassword">ชื่อ</label>
                  <div class="controls">
                    <input type="text" name="booksearch" /><td colspan="2">
                  </div>
                </div>
                <div class="control-group">
                  <div class="controls">
                    <button type="submit" name="btn_Search" class="btn btn-warning">ค้นหา</button>
                  </div>
                </div>
               <input type="hidden" name="page" value="search"/><td colspan="2">
            </form>
HTMLBLOCK;
           }
            
  mysqli_close($conn);
?>
            </<div>
    </div>
</div>
</div>
</body>
</html>
