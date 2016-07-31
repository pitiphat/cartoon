<div class="row"> <!--menu Left-->
    <div class="span3">		
        <div class="well">
        <?php 
            if(!isset($_GET["subMenu"])) {
		$_GET["subMenu"] =1;
            }
            echo '<ul class="nav nav-pills nav-stacked">';
            if ($_GET["page"] == "book"){
		
                if($_GET["subMenu"] == 1){
                        echo '<li class="active">';
                    }
                else {
                        echo '<li>';
                }
                echo '<a href="manageTitleBook.php?page=book&subMenu=1">จัดการเรืองหนังสือ</a></li>';
                if($_GET["subMenu"] == 2){
                        echo '<li class="active">';
                }
                else {
                        echo '<li>';
                }
                echo '<a href="manageBook.php?page=book&subMenu=2">จัดการหนังสือ</a></li>';
		
            }
					
            else if ($_GET["page"] == "category"){
		echo '<li class="active">';

		echo '<a href="DataCategoryBook.php?page=category&subMenu=1">จัดการหมวดหมู่</a></li>';
            }
            else if ($_GET["page"] == "fine"){
		
                echo '<li class="active">';

		echo '<a href="manageFine.php?page=fine&subMenu=1">จัดการค่าปรับ</a></li>';
		
            }
            else if ($_GET["page"] == "promotion"){
                echo '<li class="active">';

		echo '<a href="DataPromotion.php?page=promotion">จัดการโปรโมชัน</a></li>';
            }
            
            else if ($_GET["page"] == "employee"){
               
                    echo '<li class="active">';
               
                echo '<a href="manageEmployee.php?page=employee&subMenu=1">จัดการพนักงาน</a></li>';
               
            }
            else if ($_GET["page"] == "member"){
                echo '<li class="active">';
                echo '<a href="dataMember.php?page=member">จัดการสมาชิก</a></li>';
            }
            else if ($_GET["page"] == "borrow" || $_GET["page"] == "return"){
                echo '<img src="../img/PROMOTION.png"/>';
                include("method/showPromotion.php");
            }
            else if ($_GET["page"] == "report"){
                if($_GET["subMenu"] == 1 || $_GET["subMenu"] == null){
                    echo '<li class="active">';
                }
                else {
                    echo '<li>';
                }
                echo '<a href="reportBorrow.php?page=report&subMenu=1">รายงานการเช่า</a></li>';
                if($_GET["subMenu"] == 2){
                    echo '<li class="active">';
                }
                else {
                    echo '<li>';
                }
                echo '<a href="reportReturn.php?page=report&subMenu=2">รายงานการคืน</a></li>';
                if($_GET["subMenu"] == 3){
                    echo '<li class="active">';
                }
                else {
                    echo '<li>';
                }
                echo '<a href="reportBook.php?page=report&subMenu=3">รายงานหนังสือในร้าน</a></li>';
                if($_GET["subMenu"] == 4){
                    echo '<li class="active">';
                }
                else {
                    echo '<li>';
                }
                echo '<a href="reportReturnOver.php?page=report&subMenu=4">รายงานหนังสือเช่าเกินกำหนด</a></li>';
                
                echo '<li class="dropdown-submenu">
                            <a  href="#">รายงานรายได้</a>
                            <ul class="dropdown-menu">
                              <li><a tabindex="-1" href="reportProfit.php?page=report&subMenu=5">การยืม</a></li>
                              <li><a tabindex="-1" href="reportProfit2.php?page=report&subMenu=6">การคืน</a></li>
                              <li><a tabindex="-1" href="reportProfit3.php?page=report&subMenu=6">รวมรายได้</a></li>
                            </ul>
                      </li>';
                
            }
            else if ($_GET["page"] == "search"){
                if($_GET["subMenu"] == 1 || $_GET["subMenu"] == null){
                    echo '<li class="active">';
                }
                else {
                    echo '<li>';
                }
                echo '<a href="searchBook.php?page=search&subMenu=1">ค้นหาหนังสือ</a></li>';
                if($_GET["subMenu"] == 2){
                    echo '<li class="active">';
                }
                else {
                    echo '<li>';
                }
                echo '<a href="searchMember.php?page=search&subMenu=2">ค้นหาประวัติสมาชิก</a></li>';
            }
            echo '</ul>';
?>  
	</div>
    </div>
