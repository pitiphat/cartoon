<?php
if (isset($_POST["Category_button"])) {
	
	
		
	$serverName   	= "localhost";
	$userName    	= "root";
	$userPassword   = "";
	$dbName   		= "cartoon";
	
            $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
                mysqli_set_charset($conn, 'utf8');


                if(isset($_POST['Category_button'])){
                        $sql = "update category_book set Category_Name='{$_POST['Category_Name']}',Category_Status='{$_POST['cateStatus']}' where Category_Id ='{$_POST['Category_Id']}'";
                        $objQuery=mysqli_query($conn,$sql);
                        
                }
                if($objQuery != ""){
		
                    header("location:DataCategoryBook.php?page=category");
                }
                else{  
                    header("location:DataCategoryBook.php?page=category&edit={$_POST['Category_Id']}");
                }   

}
	
?>