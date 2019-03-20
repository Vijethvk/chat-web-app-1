<?php

//fetch_user.php

include('database_connection.php');

session_start();

$query = "
SELECT * FROM login 
WHERE user_id = '".$_SESSION['otheruser']."' 
";



$result=mysqli_query($link,$query);

$output = '
<table class="table table-bordered table-striped">
 <tr>
  <td>Username</td>
  <td>Status</td>
  <td>Action</td>
 </tr>
';

while ($row=mysqli_fetch_array($result))
{
      $status = '';
 $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 30 second');
 $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
 $user_last_activity = fetch_user_last_activity($row['user_id'], $link);
 // echo $user_last_activity."<br>";
  $notify="hry";
 if($user_last_activity >= $current_timestamp)
 {
   $_SESSION['notify']='Online';
  $status = '<span class="label label-success">Online</span>';
 }
 else
 {
   $_SESSION['notify']='Offline';
  $status = '<span class="label label-danger">Offline</span>';
 }
  $output .= '
  <tr>
  <td>'.$row['username'].' '.count_unseen_message($row['user_id'], $_SESSION['user_id'], $link).' '.fetch_is_type_status($row['user_id'], $link).'</td>
  <td>'.$status.'</td>
  <td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'">Start Chat</button></td>
 </tr>
 ';
}

$output .= '</table>';

echo $output;
//echo "current: ".$current_timestamp;
?>
  