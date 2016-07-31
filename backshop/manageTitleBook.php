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
<script src="../js/jquery-2.1.3.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){
    $("#test").hide();
     $("#basicModal").on('shown', function() {
         alert("adwd");
        var bookNo = $("#hid_bookNo").val();
        $("#bookNoModal").val(bookNo);
    });
    
       
       if($("#chkCate").val()=="FALSE" || $("#chkFine").val()=="FALSE") {
         $("#btnEditTitle").prop("disabled",true);
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
        
        $chkFine="FALSE";
        $chkCate="FALSE";
        if(isset($_GET['edit'])){
            
            $sql = "select * from book where Book_No='{$_GET['edit']}'";
            $result = mysqli_query($conn,$sql);
            $dataLoad = mysqli_fetch_array($result);
            
            if($dataLoad['Title_Status']=="Open"){
                $dataLoad['Title_Status']="เปิดใช้งาน";
            }
            else if($dataLoad['Title_Status']=="Remove"){
                $dataLoad['Title_Status']="ปิดการใช้งาน";
            }

        }

		//---------- หมวดหมู่ ----------------------------------------------------
    $sql = "select * from category_book
            where Category_Status = 'Open'
            order by Category_Name asc";
    $result = mysqli_query($conn,$sql); 
    $htmlCategory = '<select name="categoryId">';
    while($array=mysqli_fetch_array($result)){
        if(isset($dataLoad) && $array['Category_Id'] == $dataLoad['Category_Id']){
                $select = 'selected';
                $chkCate="TRUE";
        }
        else{
                $select = '';
        }
            $htmlCategory .= "<option value=\"{$array['Category_Id']}\" $select>{$array['Category_Name']}</option>";
    }
    $htmlCategory .= '</select>';
    
  

    //---------- ค่าปรับ ----------------------------------------------------
    $sql = "select * from fine
            where Fine_Status = 'Open'
            order by Fine_Price asc";
    $result = mysqli_query($conn,$sql); 
    $htmlFine = '<select name="fineId">';
    while($array=mysqli_fetch_array($result)){
        if(isset($dataLoad) && $array['Fine_Id'] == $dataLoad['Fine_Id']){
                $select = 'selected';
                $chkFine="TRUE";
        }
        else{
                $select = '';
        }
            $htmlFine .= "<option value=\"{$array['Fine_Id']}\" $select>{$array['Fine_Price']}</option>";
    }
    $htmlFine .= '</select>';
    
    //---------- สถานะ Title Book ----------------------------------------------------
    
		$bStatus=array("เปิดใช้งาน", "ปิดการใช้งาน");
		
		$htmlBookStatus = '<select name="bookStatus">';
		foreach($bStatus as $status_value){
			if(isset($dataLoad) && $status_value ==$dataLoad['Title_Status']){
				$select = 'selected';
			}
			else{
				$select = '';
			}
			$htmlBookStatus .= "<option value=\"$status_value\" $select>$status_value</option>";
		}
		$htmlBookStatus .= '</select>';
    
       //----------------------------------------------------------------------------------
                        
	if(isset($_GET['delete'])){ //ลบเรื่อง

                $sql = "UPDATE book
			SET Title_Status='Remove'
			WHERE Book_No='{$_GET['delete']}'";
		$result = mysqli_query($conn,$sql);
                
                $_SESSION["massageEditbook"] = "success";
                header("location:manageTitleBook.php?page=book&subMenu=1");
                        
	}	
		
	
        if(isset($_POST['btnAddTitle'])){ //เพิ่มผู้แต่ง
            
                   $sql = "insert into author (Book_No, Author)
                           values('{$_POST['bookNoModal']}','{$_POST['titleName']}')";
                           $result = mysqli_query($conn,$sql);
                   header("location:manageTitleBook.php?page=book&subMenu=1&edit={$_POST['bookNoModal']}");
        }
        
        if(isset($_GET['deleteATB']) and isset($_GET['deleteATN'])){  //ลบผู้แต่ง
            
             $sql = "select * from author where Book_No='{$_GET['deleteATB']}'";
             $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>1){
                    $sql = "DELETE FROM author where Book_No='{$_GET['deleteATB']}'and Author='{$_GET['deleteATN']}'";
                    $result = mysqli_query($conn,$sql);
                    header("location:manageTitleBook.php?page=book&subMenu=1&edit={$_GET['edit']}");
                }
                else{
                        echo'   <div class="alert alert-error">';
                        echo '<button type="button" class="close" data-dismiss="alert"> &times </button>';
                        
                        echo "ไม่สามารถลบผู้แต่งได้";
                        echo '</div>';

                }
        }
	if(isset($_GET['edit'])){ // ฟอร์มสำหรับแก้ไขหนังสือ
echo <<<HTMLBLOCK
             <div class="alert alert-error" id="test">
               กรณาตรวจสอบค่าปรับ และ หมวดหมู่ ว่าถูกปิดการใช้งานอยู่หรือไม่
            </div>
  <form class="form-horizontal" action="method/mEditTitleBook.php" method="POST">
      
  <div class="control-group">
    <label class="control-label">รหัสชื่อเรื่อง</label>
    <div class="controls">
    <input name="bookNo" type="text" value="{$dataLoad['Book_No']}"readonly/>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">ISBN <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
          <input name="isbn" type="text" maxlength="13" value="{$dataLoad['ISBN']}" required/>
    </div>
  </div>
    <div class="control-group">
    <label class="control-label">ชื่อหนังสือ <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
         <input name="bookName" type="text" maxlength="25" value="{$dataLoad['Book_Name']}" required/>
  </div>
    </div>
    <div class="control-group">
    <label class="control-label">สำนักพิมพ์ <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
          <input name="press" type="text" maxlength="25" value="{$dataLoad['Press']}" required/>
    </div>
  </div>
    <div class="control-group">
    <label class="control-label">ค่าเช่า <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
          <input name="rentPrice" type="text" maxlength="4" value="{$dataLoad['Rent_Price']}" required/> บาท
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">วันที่ยืมได้ <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
          <input name="d_quan" type="text" value="{$dataLoad['Date_Quantity']}" required/> วัน
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">หมวดหมู่ <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
          <input name="chkCate" id="chkCate" type="hidden" value="{$chkCate}"/>
          $htmlCategory
    </div>
  </div>
    <div class="control-group">
    <label class="control-label">ค่าปรับ <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
          <input name="chkFine" id="chkFine" type="hidden" value="{$chkFine}"/>
         $htmlFine บาท
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">สถานะ <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
         $htmlBookStatus
    </div>
  </div>
                  
  <input name="hid_bookNo" id="hid_bookNo" type="hidden" value="{$dataLoad['Book_No']}">
HTMLBLOCK;
          
        $sql = "select * from author where Book_No='{$_GET['edit']}'";
        $result = mysqli_query($conn,$sql);
        while($array=mysqli_fetch_array($result)){
            echo <<<HTMLBLOCK
             <div class="control-group">
            <label class="control-label">ผู้แต่ง <strong class="text-error" style="font-size: 20px">*</strong></label>
                <div class="controls">
                    <input name="author" type="text" value="{$array['Author']}"readonly/>
                     <div class="input-append">
         /* ปุ่มเพิ่ม */   <button class="btn btn-lg" id="mo"
                       data-toggle="modal" data-target="#basicModal">
                       เพิ่ม
                       </button>
         /* ปุ่มลบ */     <a href='manageTitleBook.php?page=book&subMenu=1&edit={$array['Book_No']}&deleteATB={$array['Book_No']}&deleteATN={$array['Author']}'><button class="btn" type="button">ลบ</button></a>
                     </div>
                </div>
             </div>
         
HTMLBLOCK;
        }

    echo <<<HTMLBLOCK
  <div class="control-group">
    <div class="controls">
      <button type="submit" name="btnEditTitle" id="btnEditTitle" class="btn btn-warning">บันทึก</button>
    </div>
  </div>
</form>
HTMLBLOCK;
	}
               
        else{ // แสดงเรื่องทั้งหมดที่แก้ไขได้
                $sql = "select *
                        from book a1, fine a2
                        where a1.Fine_Id=a2.Fine_Id
                        ORDER BY Book_No DESC";
                $result = mysqli_query($conn, $sql);
                
                
                echo"<p class='text-right'><a class='btn-small btn-primary' href='newTitleBook.php?page=book&subMenu=1'><i class='icon-plus-sign icon-white'></i>เพิ่ม</a></p>";
                $html = '<table class="table table-hover">'; 
                $html .= '<tr><th>รหัสชื่อเรื่อง</th><th>ชื่อหนังสือ</th><th>วันที่ยืมได้</th><th>ค่าเช่า</th><th>ค่าปรับ</th><th>สถานะ</th></tr>';
                while($array=mysqli_fetch_array($result)){
                    
                    if($array['Title_Status']=="Open"){
                        $status="เปิดใช้งาน";
                    }
                    else if($array['Title_Status']=="Remove"){
                        $status="ปิดการใช้งาน";
                    }
                   
                    $html = $html ."<tr class='info'><td>{$array['Book_No']}</td>";
                    
                    $html = $html ."<td>{$array['Book_Name']}</td>";
        
                    $html = $html ."<td>{$array['Date_Quantity']}</td>";
                    $html = $html ."<td>{$array['Rent_Price']}</td>";
                    $html = $html ."<td>{$array['Fine_Price']}</td>";
                 
                    $html = $html ."<td>$status</td>";
                    $html = $html ."<td><div class='btn-group'>
                                    <a class='btn btn-mini' href='manageTitleBook.php?page=book&subMenu=1&edit={$array['Book_No']}'><i class='icon-pencil'></i> แก้ไข</a>
                                    <a class='btn btn dropdown-toggle' data-toggle='dropdown' href='#'><span class='caret'></span></a>
                                    <ul class='dropdown-menu'>
                                      <li><a href='manageTitleBook.php?page=book&subMenu=1&edit={$array['Book_No']}'><i class='icon-pencil'></i> แก้ไข</a></li>
                                      <li><a href='manageTitleBook.php?page=book&subMenu=1&delete={$array['Book_No']}'><i class='icon-trash'></i> ปิดใช้งาน</a></li>
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



<div class="modal fade" id="basicModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h3>ผู้แต่ง</h3>
            </div>
            <div class="modal-body">
                <form role="form" action="manageTitleBook.php" method="post">
                    <div class="form-group">
                        <label for="email">ชื่อผู้แต่ง</label>
                        <input type="text" class="form-control" id="titleName" 
                        name="titleName" maxlength="20" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" 
                        id="bookNoModal" name="bookNoModal">
                    </div>
                   
                    <button type="submit" name="btnAddTitle" class="btn btn-default"> ยืนยัน </button>
                </form>
            </div>
            <div class="modal-footer">
                Please fill your information.
            </div>
        </div>
    </div>
</div>
