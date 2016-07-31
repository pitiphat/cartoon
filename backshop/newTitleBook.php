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

<script language="javascript">
    $(document).ready(function(){
    var next = 1;
    $(".add-more").click(function(e){
		
		
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;
        var newIn = '<input autocomplete="off" class="input form-control" id="field' + next + '" name="field[]" type="text" maxlength="20" required/>';
        var newInput = $(newIn);
        var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >-</button></div><div id="field">';
        var removeButton = $(removeBtn);
        $(addto).after(newInput);
        $(addRemove).after(removeButton);
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);  
        
            $('.remove-me').click(function(e){
                e.preventDefault();
                var fieldNum = this.id.substr(this.id.lastIndexOf("e")+1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
            });
		
    });
   
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
        {
            echo'   <div class="alert alert-success">';
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
    include("method/configDB.php"); //connect DB

    $sql = 'select max(Book_No)+1 as nextBookNo from book';
    $result = mysqli_query($conn,$sql); 
    $load_Id = mysqli_fetch_array($result);

    if($load_Id['nextBookNo']==null){ 
            $newBookNo = '001'; 
    }
    else{ 
            $newBookNo = sprintf('%03s',$load_Id['nextBookNo']); 
    }

    //---------- หมวดหมู่ ----------------------------------------------------
    $sql = "select * from category_book
            where Category_Status = 'Open'
            order by Category_Name asc";
    $result = mysqli_query($conn,$sql); 
    $htmlCategory = '<select name="categoryId">';
    while($array=mysqli_fetch_array($result)){
            $htmlCategory .= "<option value=\"{$array['Category_Id']}\">{$array['Category_Name']}</option>";
    }
    $htmlCategory .= '</select>';

    //---------- ค่าปรับ ----------------------------------------------------
    $sql = "select * from fine
            where Fine_Status = 'Open'
            order by Fine_Price asc";
    $result = mysqli_query($conn,$sql); 
    $htmlFine = '<select name="fineId">';
    while($array=mysqli_fetch_array($result)){
            $htmlFine .= "<option value=\"{$array['Fine_Id']}\">{$array['Fine_Price']}</option>";
    }
    $htmlFine .= '</select>';

    
    
    mysqli_close($conn);
    
?>
    
	
<form class="form-horizontal" action="method/mNewTitleBook.php" method="POST" enctype="multipart/form-data">
  <div class="control-group">
      <label class="control-label">รหัสชื่อเรื่อง</label>
    <div class="controls">
      <input name="bookNo" type="text" value="<?php echo $newBookNo;?>"readonly/>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">ISBN <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
          <input name="isbn" maxlength="13" type="text" required/>
    </div>
  </div>
    <div class="control-group">
    <label class="control-label">ชื่อหนังสือ <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
         <input name="bookName" maxlength="25" type="text" required/>
  </div>
    </div>
    <div class="control-group">
    <label class="control-label">สำนักพิมพ์ <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
          <input name="press" maxlength="25" type="text" required/>
    </div>
  </div>
    <div class="control-group">
    <label class="control-label">ค่าเช่า <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
          <input name="rentPrice" maxlength="4" type="text" required/> บาท
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">วันที่ยืมได้ <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
          <input name="d_quan" maxlength="3" type="text" required/> วัน
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">หมวดหมู่ <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
          <?php echo $htmlCategory; ?>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">ค่าปรับ <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
         <?php echo $htmlFine; ?> บาท
    </div>
  </div>
  <div id="field">
  <div class="control-group">
    <label class="control-label">ผู้แต่ง <strong class="text-error" style="font-size: 20px">*</strong></label>
    <div class="controls">
        <div id="field">
            <input autocomplete="off" class="input" id="field1" name="field[]" type="text"
            data-items="8" maxlength="20" required/><button id="b1"class="btn add-more" type="button">+</button>
    	</div>

    </div>
  </div>
    
  <div class="control-group">
    <div class="controls">
      <button type="submit" name="addNewTitle" class="btn btn-warning">บันทึก</button>
    </div>
  </div>
</form>
    
    </<div>
    </div>
</div>
</div>

</body>
</html>
