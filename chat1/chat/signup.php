<?php
include('database_connection.php');
$message='';
session_start();
if(isset($_SESSION['user_id']))
{
 header('location:index.php');
}

if(isset($_POST["login"]))
{
 $query = "
   SELECT * FROM login 
    WHERE user_id ='".mysqli_real_escape_string($link,$_POST['user_id'])."' LIMIT 1";
      $result=mysqli_query($link,$query);   
  
  if(mysqli_num_rows($result)>0)
  {
     header("location:login.php");  
  }
 else
 {
 /* $query="INSERT INTO `login` (`user_id`,`username`,`password`,`email`) VALUES ('".mysqli_real_escape_string($link,$_POST['user_id'])."','".mysqli_real_escape_string($link,$_POST['username'])."','".mysqli_real_escape_string($link,$_POST['password'])."''".mysqli_real_escape_string($link,$_POST['email'])."')";
        if(mysqli_query($link,$query))
          header('location:login.php');
        else
            echo 'error'; */
   
   
   $squery="SELECT * FROM dummy WHERE user_id='".$_POST['delete']."' LIMIT 1"; 
   if($result1 = mysqli_query($link,$squery))
      $row1 = mysqli_fetch_assoc($result1);
   
      $match=md5($_POST['user_id']);
      if (password_verify($match,$row1['user_id']))
      { 
   $sub_query = "
        INSERT INTO login 
        (user_id,username,password,email,custid) 
        VALUES ('".$_POST['user_id']."','".$_POST['username']."','".$_POST['password']."','".$_POST['email']."','".$row1['custid']."')";
  
   
    if(mysqli_query($link,$sub_query))
    {
       $_SESSION['user_id'] =$_POST['user_id'];
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['notify'] = "";
        $_SESSION['otheruser'] = $row1['custid'];
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
      echo 'error try again to signup';
        
   }
   else
      $message = "<label>Please signup with the same credential that you provided to the friendskart</label>";
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
      <style>
  
      </style>
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
      <div class="panel-heading">You Need to SignUp Again With Same Credentials In Order To Chat With Our Customer</div>
    <div class="panel-body">
     <form method="post" id="login">
       <p class="text-danger"><?php echo $message; ?></p>
      <div class="form-group">
       <label>Enter User ID(SR-NO)</label>
       <input type="text" name="user_id" class="form-control" required value="" id="userid"/>
         <input type="hidden" name="delete" class="form-control"  value="<?php echo $_GET['delete']; ?>" id="delete_id"/>
      </div>
      <div class="form-group">
         <label>Enter Username</label>
         <input type="text" id="username" name="username" 
                class="form-control" required value="">
       </div>
       <div class="form-group">
         <label>Enter Email</label>
         <input type="email" id="email" name="email" 
                class="form-control" required value="">
       </div>
       <div class="form-group">
         <label>Enter Password</label>
         <input type="password" id="password" name="password" 
                class="form-control" required value="">
         <input type="checkbox" onclick="myFunction()"><span>Show Password</span>
       </div>
      <div class="form-group">
        <div style="text-align:center">
       <input type="submit" name="login" class="btn btn-info" value="Signup" style="text-align:center" id="loginform"/>
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