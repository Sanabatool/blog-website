<?php


include('connect.php');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pwd = mysqli_real_escape_string($conn,sha1($_POST['password']));
    $cpwd = mysqli_real_escape_string($conn,sha1($_POST['Cpassword']));
   $role = mysqli_real_escape_string($conn,$_POST['role']);
  //  $roll = $_POST['roll'];

  if(strlen($name) < 4 || strlen($name) > 100){
  $error = "username must be minimum 4 char";
  }
  elseif($pwd!=$cpwd){
    $error = "password doesn't match";
  }
  else {
    $sql = "SELECT * from users WHERE email = '$email'";
    $query = mysqli_query($conn,$sql);
    $row = mysqli_num_rows($query);
    if($row >= 1){
        $error = "eamil alredy exist";
    }
    else{
        $sql2 = "INSERT INTO `users` (username, email, password, role) VALUES ('$name', '$email', '$pwd', '$role')";
        $result = mysqli_query($conn, $sql2);

        if ($result) {
           $msg = ['added successfully','alert-success'];
           $_SESSION['msg']=$msg;
             header("Location: login.php");
            // exit();
        } else {
            echo "<script>alert('Submit failed')</script>";
        }
    }
  }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="full-screen-container">
        <div class="login-container">
            <h1 class="login-title">Welcome</h1>
           <?php
           if(!empty($error)){
            echo "<p class = 'bg-danger text-white p-2'>".$error."</p>";
           }
           ?>
            <form id="form" action="" class="form" method="post">
            <div class="input-group success">
                    <label for="name">Name: </label>
                    <input type="name" name="name" id="name" required>
                </div>
                <div class="input-group success">
                    <label for="email">Email: </label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="input-group error">
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="input-group error">
                    <label for="Cpassword">Confirm Password: </label>
                    <input type="Cpassword" name="Cpassword" id="Cpassword" required>
                </div>
                <div class="input-group success">
                    <label for="roll">Select: </label>
                   <select name="role" required>
                    <option value="">Select Role</option>
                    <option value="1">Admin</option>
                    <option value="0">Co-Admin</option>
                   </select>
                </div>
                <button type="submit" class="login-button" name="submit">Register</button>
            </form>
        </div>
    </div>
</body>
</html>