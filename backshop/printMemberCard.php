<?php

if(isset($_GET['memName'])){
echo "<table border=1 width='400'>
<tr>
<td colspan = 2 align='center'>บัตรสมาชิกร้าน การ์ตูนคลับโซน</td>
</tr>
<tr>
<td>รหสัสมาชิก</td><td>{$_GET['memid']}</td>
</tr>
<tr>    
<td>{$_GET['memName']}</td><td>{$_GET['memLname']}</td></tr>
";
}
?>

