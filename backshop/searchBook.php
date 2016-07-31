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

<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" />

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

                include("method/configDB.php"); //connect DB

                include 'method/searchBookResult.php';

           if(isset($_GET['btn_Search'])){
                fnc_search_result();
           }
           else{
            echo <<<HTMLBLOCK
            <form class="form-horizontal" action="searchBook.php" method="GET">
                <div class="control-group">
                  <label class="control-label" for="inputEmail">ค้นหาจาก <strong class="text-error" style="font-size: 20px">*</strong></label>
                  <div class="controls">
                    <select name="selectBook" id="select">
                      <option value="book">ชื่อหนังสือ</option>
                      <option value="category">ประเภทหนังสือ</option>
                      <option value="press">สำนักพิมพ์</option>
                    </select></td>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="inputPassword">ชื่อ <strong class="text-error" style="font-size: 20px">*</strong></label>
                  <div class="controls">
                    <input type="text" name="booksearch"/><td colspan="2">
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
