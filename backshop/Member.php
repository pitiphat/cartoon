<?php
if (isset($_POST["Register"])) {

	
		
	$serverName   	= "localhost"; 
	$userName    	= "root";
	$userPassword   = "";
	$dbName   	= "cartoon";
	
    $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
	mysqli_set_charset($conn, 'utf8');
	
	
	if(isset($_POST['Register'])){
		$sql = "update member set Mem_Name='{$_POST['Mem_Name']}',Mem_Lastname='{$_POST['Mem_Lastname']}',Mem_Pass='{$_POST['password']}',
		Gender='{$_POST['gender']}',Address='{$_POST['address']}',Tel='{$_POST['Tel']}',Mem_Status='{$_POST['MemStatus']}',Id_Card='{$_POST['Id_Card']}' where Mem_Id ='{$_POST['memid']}'";
     
                $objQuery=mysqli_query($conn,$sql);
	
        }
         if($objQuery != ""){
		
                    header("location:printMemberCard.php?memid={$_POST['memid']}&memName={$_POST["Mem_Name"]}&memLname={$_POST["Mem_Lastname"]}");
                }
                else{  
                     header("location:DataMember.php?page=member&edit={$_POST['memid']}");
                
                } 
}
mySqli_Close ($conn);

?>