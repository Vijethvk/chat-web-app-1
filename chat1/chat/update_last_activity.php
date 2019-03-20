<?php

//update_last_activity.php

include('database_connection.php');

session_start();

 $time = strtotime(date("Y-m-d H:i:s") . '00 second');
 $time = date('Y-m-d H:i:s', $time);

$query = "
UPDATE login_details 
SET last_activity = '".$time."' 
WHERE login_details_id = '".$_SESSION["login_details_id"]."'
";
$result=mysqli_query($link,$query);

echo $time;

?>