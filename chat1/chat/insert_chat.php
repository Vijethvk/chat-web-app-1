<?php

//insert_chat.php

include('database_connection.php');
 $time = strtotime(date("Y-m-d H:i:s") . '00 second');
 $time = date('Y-m-d H:i:s', $time);

session_start();

/*$data = array(
 ':to_user_id'  => $_POST['to_user_id'],
 ':from_user_id'  => $_SESSION['user_id'],
 ':chat_message'  => $_POST['chat_message'],
 ':status'   => '1'
);*/

//echo $_POST['to_user_id']."<br>".$_SESSION['user_id']."<br>".$_POST['chat_message']."<br>";

/*$query = "
INSERT INTO chat_message 
(to_user_id, from_user_id, chat_message, status) 
VALUES (:to_user_id, :from_user_id, :chat_message, :status)
";*/

//$query="INSERT INTO `chat_message` (`to_user_id`, `from_user_id`, `chat_message`,`status`) VALUES (".$_POST['to_user_id'].",".$_SESSION['user_id'].",".$_POST['chat_message'].",'1')";

$query="INSERT INTO `chat_message` (`chat_message_id`, `to_user_id`, `from_user_id`, `chat_message`, `timestamp`, `status`) VALUES (NULL, '". $_POST['to_user_id']."', '".$_SESSION['user_id']."', '".$_POST['chat_message']."', '".$time."', '1')";


 mysqli_query($link,$query);

 echo fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id'], $link);


?>
