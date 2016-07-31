
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>


</head>

<body>
<?php
    $serverName   	= "localhost";
    $userName    	= "root";
    $userPassword       = "";
    $dbName   		= "cartoon"; 
    $conn = mysqli_connect($serverName,$userName,$userPassword,$dbName);
    mysqli_set_charset($conn, 'utf8');
    
    $sql = "select *from book";
    $result = mysqli_query($conn, $sql);
    
    echo "<table border=1>";
    while($array=mysqli_fetch_array($result)){
        echo"<tr>";
        echo "<td>{$array['Book_Name']}</td>";
        echo "<td>{$array['ISBN']}</td>";
        echo "<tr>";
    }
    echo "</table>";
?>
    
        

            </form>
        </<div>
    </div>
</<div>

</body>
</html>
