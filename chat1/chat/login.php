<?php
//session_destroy();
include('database_connection.php');


$message='';
//echo $_POST['first'];
//echo $_POST['second'];
session_start();
if(isset($_POST['second']))
{
//$query="UPDATE login SET custid='".$_POST['second']."'WHERE user_id='".$_POST['first']."'";
//mysqli_query($link,$query);
 $sub_query = "
        INSERT INTO dummy 
        (user_id,custid) 
        VALUES ('".$_POST['first']."','".$_POST['second']."')";
    mysqli_query($link,$sub_query);
}  
  
if(isset($_SESSION['user_id']))
{ 
 header('location:index.php');
}
//echo $_POST['user_id'];
if(isset($_POST["login"]))
{
 $query = "
   SELECT * FROM login 
    WHERE user_id ='".mysqli_real_escape_string($link,$_POST['user_id'])."' LIMIT 1";
      $result=mysqli_query($link,$query);   
   //   print_r($result);
 // $squery="SELECT * FROM login WHERE user_id='".$_POST['user_id']."' LIMIT 1"; 
   //if($result1 = mysqli_query($link,$squery))
     // $row1 = mysqli_fetch_assoc($result1);
	
 
  if(mysqli_num_rows($result)>0)
 {
   
    while ($row=mysqli_fetch_array($result))   
    {
      if($_POST["password"]== $row["password"])
      {
         $s1query="DELETE FROM dummy WHERE user_id='".$_POST['delete']."'";
      mysqli_query($link,$s1query);
        
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['notify'] = "";
        $_SESSION['otheruser'] = $_POST['delete1'];
        $sub_query = "
        INSERT INTO login_details 
        (user_id) 
        VALUES ('".$row['user_id']."')
        ";
         $result=mysqli_query($link,$sub_query); 
        $_SESSION['login_details_id'] = mysqli_insert_id($link);
        header("location:index.php");
        echo $_SESSION['login_details_id'];
      }
      else
      {
       $message = "<label>Wrong Password or Username</label>";
      }
    }
 }
 else
 {
   header('location:signup.php?delete='.$_POST['delete']);
 }
}

?>


<html>  
    <head>  
        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Chat</title>  
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script> 
    </head>  
    <body>  
        <div class="container">
   <br />
   
   <h3 align="center">friendsKart</h3><br />
   <br />
   <div class="panel panel-default">
      <div class="panel-heading">Chat With Our Customer</div>
    <div class="panel-body">
     <form method="post" id="login">
        <p class="text-danger"><?php echo $message; ?></p>
      <div class="form-group">
       <label>Enter User ID(SR-NO)</label>
       <input type="text" name="user_id" class="form-control" required value="" id="userid"/>
        <input type="hidden" name="delete" class="form-control" value="<?php echo $_POST['first']; ?>" id="delete_id"/>
        <input type="hidden" name="delete1" class="form-control" value="<?php echo $_POST['second']; ?>" id="delete_id1"/>
      </div>
      <div class="form-group">
         <label>Enter Password</label>
         <input type="password" id="password" name="password" 
                class="form-control" required value="">
        <input type="checkbox" onclick="myFunction()"><span>Show Password</span>
       </div>
      <div class="form-group">
        <div style="text-align:center">
       <input type="submit" name="login" class="btn btn-info" value="Login" style="text-align:center" id="loginform"/>
        </div>  
      </div>
     </form>
    </div>
   </div>
  </div>   
      
      <script>
         function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
 
      </script>
      
      
    </body>  
</html>