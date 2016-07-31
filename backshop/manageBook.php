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

<script>

   $(document).ready(function(){
       $("#test").hide();
       if($("#chk").val()=="FALSE"){
         $("#btnEditBook").prop("disabled",true);
         $("#test").show();
       }
       
});
</script>
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
    
?>
    <?php
	include("method/configDB.php");
        include 'method/fnc_chanceYear.php';
        
        if(isset($_GET['edit'])){

                $sql = "select * from book_detail where Book_Id='{$_GET['edit']}'";
                $result = mysqli_query($conn,$sql);
                $dataLoad = mysqli_fetch_array($result);
                
                if($dataLoad['Book_Status']=="True"){
                        $dataLoad['Book_Status']="ยืมได้";
                    }
                    else if($dataLoad['Book_Status']=="False"){
                        $dataLoad['Book_Status']="ถูกยืมไปแล้ว";
                    }
                    else if($dataLoad['Book_Status']=="Invisible"){
                        $dataLoad['Book_Status']="สูญหาย";
                    }
                    else{
                        $dataLoad['Book_Status']="ปิดใช้งาน";
                    }
                        
	}

		//---------- ชื่อหนังสือ ----------------------------------------------------
		$sql = "select * from book where Title_Status='Open'
                        order by Book_Name asc";
		$result = mysqli_query($conn,$sql); 
		$htmlBookName = '<select name="bookName" id="bookName">';
                $chk="FALSE";
		while($array=mysqli_fetch_array($result)){
			if(isset($dataLoad) && $array['Book_No']==$dataLoad['Book_No']){
				$select = 'selected';
                                $chk="TRUE";
			}
			else{
				$select = '';
			}
           
			$htmlBookName .= "<option value=\"{$array['Book_No']}\" $select>{$array['Book_Name']}</option>";
		}
		$htmlBookName .= '</select>';
		
		//---------- สถานะหนังสือ ----------------------------------------------------
		$bStatus=array("ยืมได้", "ถูกยืมไปแล้ว", "สูญหาย", "ปิดใช้งาน");
		
		$htmlBookStatus = '<select name="bookStatus">';
		foreach($bStatus as $status_value){
			if(isset($dataLoad) && $status_value ==$dataLoad['Book_Status']){
				$select = 'selected';
			}
			else{
				$select = '';
			}
			$htmlBookStatus .= "<option value=\"$status_value\" $select>$status_value</option>";
		}
		$htmlBookStatus .= '</select>';
	if(isset($_GET['delete'])){

                $sql = "UPDATE book_detail
			SET Book_Status='Remove'
			WHERE Book_Id='{$_GET['delete']}'";
		$result = mysqli_query($conn,$sql);
                $_SESSION["massageEditbook"] = "success";
                header("location:manageBook.php?page=book&subMenu=2");
                        
	}	
		
		
	if(isset($_GET['edit'])){ // ฟอร์มสำหรับแก้ไขหนังสือ
		 $tempDate=changeDate($dataLoad['Book_Indate']);
                
echo <<<HTMLBLOCK
            <div class="alert alert-error" id="test">
               กรณาตรวจสอบชื่อเรื่องว่าถูกปิดการใช้งานอยู่หรือไม่
            </div>
        <form class="form-horizontal" name="form1" method="post" action="method/mEditBook.php">
        <div class="control-group">
          <label class="control-label" for="inputEmail">รหัสหนังสือ</label>
          <div class="controls">
            <input name="book_Id" type="text" value="{$dataLoad['Book_Id']}"readonly/>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">ชื่อเรื่อง <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <input name="chk" id="chk" type="hidden" value="{$chk}"/>
            $htmlBookName
          </div>
        </div>
         <div class="control-group">
          <label class="control-label" for="inputPassword">วันที่หนังสือเข้าร้าน</label>
          <div class="controls">
            <input name="Book_Indate" type="text" value="{$tempDate}"readonly/>
          </div>
        </div>
         <div class="control-group">
          <label class="control-label" for="inputPassword">เล่มที่ <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            <td><input name="vol" type="text" maxlength="3" value="{$dataLoad['Vol']}" required/>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">สถานะ <strong class="text-error" style="font-size: 20px">*</strong></label>
          <div class="controls">
            $htmlBookStatus
            
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <button type="submit" name="btnEditBook" id="btnEditBook" class="btn btn-warning">บันทึก</button>
          </div>
        </div>
       </form>
HTMLBLOCK;
	}
               
        else{ // แสดงหนังสือทั้งหมดที่แก้ไขได้
                $sql = "select d1.Book_Id, d2.Book_Name, d1.Vol, d1.Book_Status
                        from book_detail d1, book d2
                        where d1.Book_No=d2.Book_No
                        ORDER BY Book_Id DESC";
                $result = mysqli_query($conn, $sql);
                echo"<p class='text-right'><a class='btn-small btn-primary' href='newBook.php?page=book&subMenu=2'><i class='icon-plus-sign icon-white'></i>เพิ่ม</a></p>";
                $html = '<table class="table table-hover">'; 
                $html .= '<tr><th>รหัสหนังสือ</th><th>ชื่อหนังสือ</th><th>เล่มที่</th><th>สถานะ</th><th>จัดการ</th><th></th></tr>';
                while($array=mysqli_fetch_array($result)){
                    if($array['Book_Status']=="True"){
                        $status="ยืมได้";
                    }
                    else if($array['Book_Status']=="False"){
                        $status="ถูกยืมไปแล้ว";
                    }
                    else if($array['Book_Status']=="Invisible"){
                        $status="สูญหาย";
                    }
                    else{
                        $status="ปิดใช้งาน";
                    }
                    $html = $html ."<tr class='info'><td>{$array['Book_Id']}</td>";
                    $html = $html ."<td>{$array['Book_Name']}</td>";
                    $html = $html ."<td>{$array['Vol']}</td>";
                    $html = $html ."<td>$status</td>";
                    $html = $html ."<td><div class='btn-group'>
                                    <a class='btn btn-mini' href='manageBook.php?page=book&subMenu=2&edit={$array['Book_Id']}'><i class='icon-pencil'></i> แก้ไข</a>
                                    <a class='btn btn dropdown-toggle' data-toggle='dropdown' href='#'><span class='caret'></span></a>
                                    <ul class='dropdown-menu'>
                                      <li><a href='manageBook.php?page=book&subMenu=2&edit={$array['Book_Id']}'><i class='icon-pencil'></i> แก้ไข</a></li>
                                      <li><a href='manageBook.php?page=book&subMenu=2&delete={$array['Book_Id']}'><i class='icon-trash'></i> ปิดใช้งาน</a></li>
                                    </ul>
                                  </div>
                                  </td>";
                }
                    $html = $html . '</table>';
                    echo $html;
            }
	mysqli_close($conn);
        
?>
    
    </<div>
    </div>
</div>
</div>

</body>
</html>
