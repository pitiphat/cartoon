<br>
    <div class="row">
      <div class="span11">
         <ul class="nav nav-tabs">
           <li class="active">
            <?php
                if($_SESSION["UserLV"]=="99"){
                    echo '<a href="#">Shopkeeper Panel</a>';
		}
		else{
                    echo '<a href="#">Employee Panel</a>';
		}
            ?>
           </li>
         </ul>
      </div>
      <div class="span1"> <a href="logout.php"><img src="../img/k9294539.jpg" class="img-rounded" name="logOut"/></a> 
      </div>
    </div>
      <div class="row">
        <div class="span12">
            <div class="navbar navbar-inverse">
                <div class="navbar-inner">    
                    <?php
						
                        if(!isset($_GET["page"])) {
                            $_GET["page"] ="book";
                        }
                        echo '<ul class="nav">';
			if($_GET["page"] == "book"){
                            echo '<li class="active">';
			}
			else{
                            echo '<li>';
			}	
                        echo '<a href="manageTitleBook.php?page=book">หนังสือ</a></li>';
			if($_GET["page"] == "category"){
                            echo '<li class="active">';
			}
                        else{
                            echo '<li>';
                        }
			echo '<a href="DataCategoryBook.php?page=category">หมวดหมู่</a></li>';
			if($_GET["page"] == "fine"){
                            echo '<li class="active">';
			}
			else{
                            echo '<li>';
			}
			echo '<a href="manageFine.php?page=fine">ค่าปรับ</a></li>';
			if($_GET["page"] == "promotion"){
                            echo '<li class="active">';
			}
			else{
                            echo '<li>';
			}
								 
			echo '<a href="DataPromotion.php?page=promotion">โปรโมชัน</a></li>';
			if($_GET["page"] == "employee"){
                            echo '<li class="active">';
			}
			else{
                            echo '<li>';
                        }
			echo '<a href="manageEmployee.php?page=employee">พนักงาน</a></li>';
			if($_GET["page"] == "member"){
                            echo '<li class="active">';
			}
			else{
                            echo '<li>';
			}
			echo '<a href="DataMember.php?page=member">สมาชิก</a></li>';
			if($_GET["page"] == "borrow"){
                            echo '<li class="active">';
			}
			else{
                            echo '<li>';
                        }
			echo '<a href="borrow.php?page=borrow">ยืมหนังสือ</a></li>';
                        if($_GET["page"] == "return"){
                            echo '<li class="active">';
			}
			else{
                            echo '<li>';
			}
			echo '<a href="return.php?page=return">คืนหนังสือ</a></li>';
			if($_GET["page"] == "report"){
                            echo '<li class="active">';
			}
			else{
                            echo '<li>';
			}
			echo '<a href="reportBorrow.php?page=report">ออกรายงาน</a></li>';
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
