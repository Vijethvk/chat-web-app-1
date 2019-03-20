<?php
  $notify='hey boy';

  //$link=mysqli_connect("sl-aus-syd-1-portal.0.dblayer.com:21282","admin","QYEWTRXMMHROAOIQ","compose");
    $link=mysqli_connect("shareddb-i.hosting.stackcp.net","chatapp-33378387","pampwatv78","chatapp-33378387");
    if(mysqli_connect_error()){
     die("error connecting to database"); 
    }
  
date_default_timezone_set('Asia/Kolkata');



function fetch_user_last_activity($user_id, $link)
{
 $query = "
 SELECT * FROM login_details 
 WHERE user_id = '".$user_id."' 
 ORDER BY last_activity DESC LIMIT 1
 ";

  $result=mysqli_query($link,$query);
  
 while($row=mysqli_fetch_array($result))
 {
  return $row['last_activity'];
 }
}

function fetch_user_chat_history($from_user_id, $to_user_id, $link)
{
 $query = "
 SELECT * FROM chat_message 
 WHERE (from_user_id = '".$from_user_id."' 
 AND to_user_id = '".$to_user_id."') 
 OR (from_user_id = '".$to_user_id."' 
 AND to_user_id = '".$from_user_id."') 
 ORDER BY timestamp ASC
 ";
 echo mysqli_fetch_array($result);
  
  $result=mysqli_query($link,$query);
 
 $output = '<ul class="list-unstyled">';
 while($row=mysqli_fetch_array($result))
 {
  $user_name = '';
  if($row["from_user_id"] == $from_user_id)
  {
   $user_name = '<b class="text-success">You</b>';
  }
  else
  {
   $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $link).'</b>';
  }
  $output .= '
  <li style="border-bottom:1px dotted #ccc">
   <p>'.$user_name.' - '.$row["chat_message"].'
    <div align="right">
     - <small><em>'.$row['timestamp'].'</em></small>
    </div>
   </p>
  </li>
  ';
 }
 $output .= '</ul>';
  
    $query = "
 UPDATE chat_message 
 SET status = '0' 
 WHERE from_user_id = '".$to_user_id."' 
 AND to_user_id = '".$from_user_id."' 
 AND status = '1'
 ";

   $result=mysqli_query($link,$query);
  
 return $output;
}

function get_user_name($user_id, $link)
{
 $query = "SELECT username FROM login WHERE user_id = '$user_id'";
 $result=mysqli_query($link,$query);
 
 while($row=mysqli_fetch_array($result))
 {
  return $row['username'];
 }
}

function count_unseen_message($from_user_id, $to_user_id, $link)
{
 $query = "
 SELECT * FROM chat_message 
 WHERE from_user_id = '$from_user_id' 
 AND to_user_id = '$to_user_id' 
 AND status = '1'
 ";
 $result=mysqli_query($link,$query);
 $count = mysqli_num_rows($result);
 $output = '';
 if($count > 0)
 {
  $output = '<span class="label label-success">'.$count.'</span>';
 }
 return $output;
}

function fetch_is_type_status($user_id, $link)
{
 $query = "
 SELECT is_type FROM login_details 
 WHERE user_id = '".$user_id."' 
 ORDER BY last_activity DESC 
 LIMIT 1
 "; 

  $result=mysqli_query($link,$query);
  
 $output = '';
 while($row=mysqli_fetch_array($result))
 {
  if($row["is_type"] == 'yes')
  {
   $output = ' - <small><em><span class="text-muted">Typing...</span></em></small>';
  }
 }
 return $output;
}

?>
