<?php

    if(!isset($_SESSION['UserID']))
    {
        include("../login.php");
        exit();	
    }
?>
<?php
   
function fnc_search_result(){
    include("method/configDB.php"); //connect DB
        
    if(isset($_GET['btn_Search'])){
        if($_GET['selectBook']=="book"){
            $sql = "select b.Book_Id, a.Book_Name, b.Vol, a.Rent_Price, b.Book_Status, a.Date_Quantity
                    from book a, book_detail b
                    where a.Book_No=b.Book_No
                    and a.Book_Name like '%{$_GET['booksearch']}%'";
            $result = mysqli_query($conn,$sql);
             if(mysqli_num_rows($result)<1){
                echo '<div class="alert alert-error">';
                echo "<a href='searchBook.php?page=search'><button type='button' class='close' data-dismiss='alert'> &times </button></a>";
                echo "ไม่พอข้อมูล";
                echo '</div>';
                exit();
             }
            echo <<<HTMLBLOCK
             <a href='searchBook.php?page=search'><button type='button' class='close' data-dismiss='alert'> &times </button></a>
			<table class="table table-hover">
			<tr><th>รหัสหนังสือ</th><th>ชื่อหนังสือ</th><th>เล่มที่</th><th>ค่าเช่า</th>
			<th>สถานะหนังสือ</th><th>วันที่ยืมได้</th></tr>
HTMLBLOCK;
			while($array=mysqli_fetch_array($result)){
                            echo <<<HTMLBLOCK
                            <tr class='info'><td>{$array['Book_Id']}</td>
                            <td>{$array['Book_Name']}</td>
                            <td>{$array['Vol']}</td>
                            <td>{$array['Rent_Price']}</td>
                            <td>{$array['Book_Status']}</td>
                            <td>{$array['Date_Quantity']}</td>
                            <td><a href="#" onClick="window.open('method/test.php?re={$array['Book_Id']}','','width=500,height=560');">ดูข้อมูล</a></td>
                            </tr>
				
HTMLBLOCK;
			}
			echo "</table>";
        }
        else if($_GET['selectBook']=="category"){
            $sql = "select b.Book_Id, a.Book_Name, b.Vol, a.Rent_Price, b.Book_Status, a.Date_Quantity
                    from book a, book_detail b, category_book c
                    where a.Book_No=b.Book_No
                    and c.Category_Id=a.Category_Id
                    and c.Category_Name like '%{$_GET['booksearch']}%'";
            $result = mysqli_query($conn,$sql);
             if(mysqli_num_rows($result)<1){
                echo '<div class="alert alert-error">';
                echo "<a href='searchBook.php?page=search'><button type='button' class='close' data-dismiss='alert'> &times </button></a>";
                echo "ไม่พอข้อมูล";
                echo '</div>';
                exit();
             }
            echo <<<HTMLBLOCK
             <a href='searchBook.php?page=search'><button type='button' class='close' data-dismiss='alert'> &times </button></a>
			<table class="table table-hover">
			<tr><th>รหัสหนังสือ</th><th>ชื่อหนังสือ</th><th>เล่มที่</th><th>ค่าเช่า</th>
			<th>สถานะหนังสือ</th><th>วันที่ยืมได้</th></tr>
HTMLBLOCK;
			while($array=mysqli_fetch_array($result)){
				echo <<<HTMLBLOCK
				<tr class='info'><td>{$array['Book_Id']}</td>
				<td>{$array['Book_Name']}</td>
				<td>{$array['Vol']}</td>
				<td>{$array['Rent_Price']}</td>
				<td>{$array['Book_Status']}</td>
				<td>{$array['Date_Quantity']}</td>
                                <td><a href="#" onClick="window.open('method/test.php?re={$array['Book_Id']}','','width=500,height=560');">ดูข้อมูล</a></td>
                              </tr>
				
HTMLBLOCK;
			}
			echo "</table>";
        }
        
        else if($_GET['selectBook']=="press"){
            $sql = "select b.Book_Id, a.Book_Name, b.Vol, a.Rent_Price, b.Book_Status, a.Date_Quantity 
                    from book a, book_detail b
                    where a.Book_No=b.Book_No 
                    and a.Press like '%{$_GET['booksearch']}%'";
            $result = mysqli_query($conn,$sql);
             if(mysqli_num_rows($result)<1){
                echo '<div class="alert alert-error">';
                echo "<a href='searchBook.php?page=search'><button type='button' class='close' data-dismiss='alert'> &times </button></a>";
                echo "ไม่พอข้อมูล";
                echo '</div>';
                exit();
             }
            echo <<<HTMLBLOCK
             <a href='searchBook.php?page=search'><button type='button' class='close' data-dismiss='alert'> &times </button></a>
			<table class="table table-hover">
			<tr><th>รหัสหนังสือ</th><th>ชื่อหนังสือ</th><th>เล่มที่</th><th>ค่าเช่า</th>
			<th>สถานะหนังสือ</th><th>วันที่ยืมได้</th></tr>
HTMLBLOCK;
			while($array=mysqli_fetch_array($result)){
				echo <<<HTMLBLOCK
				<tr class='info'><td>{$array['Book_Id']}</td>
				<td>{$array['Book_Name']}</td>
				<td>{$array['Vol']}</td>
				<td>{$array['Rent_Price']}</td>
				<td>{$array['Book_Status']}</td>
				<td>{$array['Date_Quantity']}</td>
                                <td><a href="#" onClick="window.open('method/test.php?re={$array['Book_Id']}','','width=500,height=560');">ดูข้อมูล</a></td>
                                </tr>
				
HTMLBLOCK;
			}
			echo "</table>";
        }
        
       
    }
}
?>