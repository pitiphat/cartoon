<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
	include("configDB.php");
	$sql = "select * From promotion where Pro_Status ='Open' and Promotion_Id!='000' ORDER BY Pro_Borrow DESC";
	$result = mysqli_query($conn,$sql);
	echo "<table class='table table-hover'>";
	while($array=mysqli_fetch_array($result)){
            $temp=$array['Pro_Borrow'] - $array['Discount'];
		echo"
			<tr>
				<td><h5><p class='text-success'>เช่า &nbsp;$temp</p></h5></td>
				<td><h5><p class='text-success'>ฟรี &nbsp;{$array['Discount']}</p></h5></td>
			</tr>";	

	}
	echo"</table>";
?>
</body>
</html>
