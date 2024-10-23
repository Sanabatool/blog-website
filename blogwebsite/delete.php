<?php
include 'connect.php';

if (isset($_POST['delete_imge'])) {
  $id = $_POST['delete_id'];
  $image = $_POST['del_image'];
}
$sql = "DELETE from posts WHERE id='$id'";

$result = mysqli_query($conn, $sql);
if ($result) {
  unlink('upload/' . $image);

  header('location: admin.php');
} else {
  
  header('location: admin.php');
}
