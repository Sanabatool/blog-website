<?php
include 'connect.php';

if (isset($_POST['delete_imge'])) {
  $id = $_POST['delete_id'];
  $image = $_POST['del_image'];
}
$sql = "DELETE from categories WHERE cat_id ='$id'";

$result = mysqli_query($conn, $sql);
if ($result) {
  unlink('upload/' . $image);

  $_SESSION['status-image'] = "Data deleted successfully";
  header('location: category.php');
} else {
  $_SESSION['status-image'] = "not deleted";
  header('location: category.php');
}
