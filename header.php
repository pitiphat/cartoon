<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>


</head>

<body>
	<br>
    <div class="row">
       		<div class="span12">
             <img src="img/Bleach-Anime.jpg" width="1000" height="265" /> </div>
    </div>
        <div class="row">
       		<div class="span12">
            	<div class="navbar navbar">
                 	<div class="navbar-inner">    
                <?php

                if(!isset($_GET["page"])) {
                        $_GET["page"] ="home";
                }
                 echo '<ul class="nav">';
                                 if($_GET["page"] == "home"){
                                        echo '<li class="active">';
                                 }
                                 else{
                                        echo '<li>';
                                 }
                                 echo '<a href="index.php?page=home">หน้าหลัก</a></li>';
                                 if($_GET["page"] == "editMember"){
                                        echo '<li class="active">';
                                 }
                                 else{
                                        echo '<li>';
                                 }	
                                 echo '<a href="editMember.php?page=editMember">แก้ไขข้อมูล</a></li>';
                                 if($_GET["page"] == "historyBorrow"){
                                        echo '<li class="active">';
                                 }
                                 else{
                                        echo '<li>';
                                 }
                                 echo '<a href="historyBorrow.php?page=historyBorrow">ประวัติการยืม</a></li>';
                                 if($_GET["page"] == "search"){
                                        echo '<li class="active">';
                                 }
                                 else{
                                        echo '<li>';
                                 }
                                 echo '<a href="searchBook.php?page=search">ค้นหา</a></li>';


                echo   '</ul>';
                 ?>
                  	 </div>
		</div>
            </div>
</div>
 
</body>
</html>
