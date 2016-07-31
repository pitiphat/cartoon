<?php
	if(isset($_POST["Enter"])) {
		
	
			$serverName   	= "localhost";
			$userName    	= "root";
			$userPassword   = "";
			$dbName   	= "cartoon";
	
			$conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
			mysqli_set_charset($conn, 'utf8');
                        $temp=$_POST['proborrow'] + $_POST['discount'];
			$sql = "update promotion set Pro_Borrow={$temp},Discount={$_POST['discount']},Pro_Status='{$_POST['ProStatus']}'
                                where Promotion_Id ='{$_POST['proid']}'";
                        echo $sql;
			
			// คำสั่งที่เพิ่มข้อมุลลงไปในตาราง database บรรทัด value ด้วย
			$objQuery = mysqli_query($conn,$sql); // เอาตัวแปร sql มาคิวรี
                            if($objQuery != ""){ 
                                header("location:DataPromotion.php?page=promotion");
                            }
                            else{
                                header("location:DataPromotion.php?page=promotion?edit={$_POST['proid']}");
                            }
	}

?>

