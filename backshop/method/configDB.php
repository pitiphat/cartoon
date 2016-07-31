<?php  
    $serverName   	= "localhost";
    $userName    	= "root";
    $userPassword       = "";
    $dbName   		= "cartoon"; 
    $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
    mysqli_set_charset($conn, 'utf8');  
?>
