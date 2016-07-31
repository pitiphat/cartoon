<?php

    if(!isset($_SESSION['UserID']))
    {
        include("../login.php");
        exit();	
    }
?>
<?php
   
function fnc_search_Member_result(){
    include("method/configDB.php"); //connect DB
        
    if(isset($_GET['btn_Search'])){
        if($_GET['selectMem']=="memId"){
            $sql = "select *from member where Mem_Id like '%{$_GET['memsearch']}%'";
            $result = mysqli_query($conn,$sql);
             if(mysqli_num_rows($result)<1){
                echo '<div class="alert alert-error">';
                echo "<a href='searchMember.php?page=search&subMenu=2'><button type='button' class='close' data-dismiss='alert'> &times </button></a>";
                echo "ไม่พอข้อมูล";
                echo '</div>';
                exit();
             }
            echo <<<HTMLBLOCK
             <a href='searchMember.php?page=search&subMenu=2'><button type='button' class='close' data-dismiss='alert'> &times </button></a>
			<table class="table table-hover">
			<tr><th>รหัสสมาชิก</th><th>ชื่อสมาชิก</th><th>นามสกุลสมาชิก</th><th>เบอร์โทร</th>
			<th>เพศ</th></tr>
HTMLBLOCK;
			while($array=mysqli_fetch_array($result)){
echo <<<HTMLBLOCK
                            <tr class='info'>
                            <td>{$array['Mem_Id']}</td>
                            <td>{$array['Mem_Name']}</td>
                            <td>{$array['Mem_Lastname']}</td>
                            <td>{$array['Tel']}</td>
                            <td>{$array['Gender']}</td>
                            <td><a href="#" onClick="window.open('method/fullMember.php?re={$array['Mem_Id']}','','width=500,height=560');">ดูข้อมูล</a></td>
                            </tr>
				
HTMLBLOCK;
			}
			echo "</table>";
        }
        
        if($_GET['selectMem']=="memName"){
            $sql = "select *from member where Mem_Name like '%{$_GET['memsearch']}%'";
            $result = mysqli_query($conn,$sql);
             if(mysqli_num_rows($result)<1){
                echo '<div class="alert alert-error">';
                echo "<a href='searchMember.php?page=search&subMenu=2'><button type='button' class='close' data-dismiss='alert'> &times </button></a>";
                echo "ไม่พอข้อมูล";
                echo '</div>';
                exit();
             }
            echo <<<HTMLBLOCK
             <a href='searchMember.php?page=search&subMenu=2'><button type='button' class='close' data-dismiss='alert'> &times </button></a>
			<table class="table table-hover">
			<tr><th>รหัสสมาชิก</th><th>ชื่อสมาชิก</th><th>นามสกุลสมาชิก</th><th>เบอร์โทร</th>
			<th>เพศ</th></tr>
HTMLBLOCK;
			while($array=mysqli_fetch_array($result)){
echo <<<HTMLBLOCK
                            <tr class='info'>
                            <td>{$array['Mem_Id']}</td>
                            <td>{$array['Mem_Name']}</td>
                            <td>{$array['Mem_Lastname']}</td>
                            <td>{$array['Tel']}</td>
                            <td>{$array['Gender']}</td>
                            <td><a href="#" onClick="window.open('method/fullMember.php?re={$array['Mem_Id']}','','width=500,height=560');">ดูข้อมูล</a></td>
                            </tr>
				
HTMLBLOCK;
			}
			echo "</table>";
        }
        
        
        
        
       
    }
}
?>
