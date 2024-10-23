<?php
session_start();
include('connect.php');

//security check
if(isset($_SESSION['user_data'])){
    header("location: http://localhost/blogwebsite/admin.php");
  }



if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $pwd = $_POST['password'];

   $sql = "SELECT * from users where email ='$email'AND password = '$pwd'";
   $query = mysqli_query($conn, $sql);
   $data = mysqli_num_rows($query);

   if($data){
    $result = mysqli_fetch_assoc($query);
    $user_data = array($result['user_id'], $result['username'],$result['role']);
    $_SESSION['user_data']= $user_data; 

    header('location: admin.php');
    exit();
   }
   else {
    $_SESSION['error']="invalid data inserted";
    header("location: login.php");
    exit();
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login_Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="full-screen-container">
        <div class="login-container">
            <h1 class="login-title">Login here</h1>
            <form id="form" action="" class="form" method="post" style="gap: 2rem;">
            <div class="input-group success">
                    <label for="roll"> </label>
                    <input type="hidden" name="role" id="role" required>
                </div>
                <div class="input-group success">
                    <label for="email">Email: </label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="input-group error">
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" required>
                </div>
                <?php
                if(isset($_SESSION['error'])){
                    $error = ($_SESSION['error']);
                    echo "<p class='bg-danger p-2 text-white'>".$error."</p>";
                    unset($_SESSION['error']);
                }
                ?>
                
                <button type="submit" class="login-button" name="submit">Login</button>
                <!-- <button type="submit" class="login-button" name="submit"  onclick="location.href='index.php'">Register</button> -->
             
            </form>
        </div>
    </div>
</body>
</html>
