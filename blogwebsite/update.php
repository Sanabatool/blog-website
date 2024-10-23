<?php
session_start();
include 'connect.php';


// Check if id is set and not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql2 = "SELECT * from posts LEFT JOIN categories ON posts.category=categories.cat_id LEFT JOIN users ON posts.author_id= users.user_id WHERE id= ' $id' ORDER BY posts.date DESC";

    $result = mysqli_query($conn, $sql2);
   

    if ($result === false) {
        die("Error: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);
} else {
    die("No id parameter provided.");
}
?>

<?php
if (isset($_POST['update'])) {

    $title = $_POST['title'];
    $description = $_POST['descript'];
    $category = $_POST['category'];
    $file = $_FILES['file']['name'];
    $old  = $_POST['old-file'];
    $tags = isset($_POST['tags']) ? $_POST['tags'] : [];

    // Check if a new file has been uploaded
    if ($file != '') {
        $newFile = $file;

        if (file_exists("upload/" . $_FILES['file']['name'])) {
            $filename = $_FILES['file']['name'];
            $_SESSION['status-image'] = $filename . "  image alredy exits";
            header('location: admin.php');
        }
    } else {
        $newFile = $old;
    }


    $sql = "UPDATE posts SET title='$title', descript ='$description', category='$category', file='$newFile' WHERE id='$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {

        if ($_FILES['file']['name'] != '') {
            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]['name']);
            unlink("upload/" . $old);
        }
           // Insert tags
    foreach ($tags as $tag_id) {
        $sql = "INSERT INTO `post_tags` (post_id, tag_id) VALUES ('$post_id', '$tag_id')";
        mysqli_query($conn, $sql);
      }

        $_SESSION['status-image'] = "updated successfully";
        header('location: admin.php');
    } else {
        $_SESSION['status-image'] = "updated fail";
        header('location: update.php');
    }
}

//fetch tags for the form
$tags_sql = "SELECT * FROM `tags`";
$tags_result = mysqli_query($conn, $tags_sql);

$cat_sql = "SELECT * from `categories`";
$cat_result = mysqli_query($conn, $cat_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">


    <!--font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Student details</title>
</head>
<style>
    body {
      padding-bottom: 30px;
      position: relative;
      min-height: 100%;
    }

    a {
      transition: background 0.2s, color 0.2s;
    }

    a:hover,
    a:focus {
      text-decoration: none;
    }

    #wrapper {
      padding-left: 0;
      transition: all 0.5s ease;
      position: relative;
    }

    #sidebar-wrapper {
      z-index: 1000;
      position: fixed;
      left: 250px;
      width: 0;
      height: 100%;
      margin-left: -250px;
      overflow-y: auto;
      overflow-x: hidden;
      background: #222;
      transition: all 0.5s ease;
    }

    #wrapper.toggled #sidebar-wrapper {
      width: 250px;
    }

    .sidebar-brand {
      position: absolute;
      top: 0;
      width: 250px;
      text-align: center;
      padding: 20px 0;
    }

    .sidebar-brand h2 {
      margin: 0;
      font-weight: 600;
      font-size: 24px;
      color: #fff;
    }

    .sidebar-nav {
      position: absolute;
      top: 75px;
      width: 250px;
      margin: 0;
      padding: 0;
      list-style: none;
    }

    .sidebar-nav>li {
      text-indent: 10px;
      line-height: 42px;
    }

    .sidebar-nav>li a {
      display: block;
      text-decoration: none;
      color: #757575;
      font-weight: 600;
      font-size: 18px;
    }

    .sidebar-nav>li>a:hover,
    .sidebar-nav>li.active>a {
      text-decoration: none;
      color: #fff;
      background: #F8BE12;
    }

    .sidebar-nav>li>a i.fa {
      font-size: 24px;
      width: 60px;
    }

    #navbar-wrapper {
      width: 100%;
      position: absolute;
      z-index: 2;
    }

    #wrapper.toggled #navbar-wrapper {
      position: absolute;
      margin-right: -250px;
    }

    #navbar-wrapper .navbar {
      border-width: 0 0 0 0;
      background-color: #eee;
      font-size: 24px;
      margin-bottom: 0;
      border-radius: 0;
    }

    #navbar-wrapper .navbar a {
      color: #757575;
    }

    #navbar-wrapper .navbar a:hover {
      color: #F8BE12;
    }

    #content-wrapper {
      width: 100%;
      position: absolute;
      padding: 15px;
      top: 100px;
    }

    #wrapper.toggled #content-wrapper {
      position: absolute;
      margin-right: -250px;
    }

    @media (min-width: 992px) {
      #wrapper {
        padding-left: 250px;
      }

      #wrapper.toggled {
        padding-left: 60px;
      }

      #sidebar-wrapper {
        width: 250px;
      }

      #wrapper.toggled #sidebar-wrapper {
        width: 60px;
      }

      #wrapper.toggled #navbar-wrapper {
        position: absolute;
        margin-right: -190px;
      }

      #wrapper.toggled #content-wrapper {
        position: absolute;
        margin-right: -190px;
      }

      #navbar-wrapper {
        position: relative;
      }

      #wrapper.toggled {
        padding-left: 60px;
      }

      #content-wrapper {
        position: relative;
        top: 0;
      }

      #wrapper.toggled #navbar-wrapper,
      #wrapper.toggled #content-wrapper {
        position: relative;
        margin-right: 60px;
      }
    }

    @media (min-width: 768px) and (max-width: 991px) {
      #wrapper {
        padding-left: 60px;
      }

      #sidebar-wrapper {
        width: 60px;
      }

      #wrapper.toggled #navbar-wrapper {
        position: absolute;
        margin-right: -250px;
      }

      #wrapper.toggled #content-wrapper {
        position: absolute;
        margin-right: -250px;
      }

      #navbar-wrapper {
        position: relative;
      }

      #wrapper.toggled {
        padding-left: 250px;
      }

      #content-wrapper {
        position: relative;
        top: 0;
      }

      #wrapper.toggled #navbar-wrapper,
      #wrapper.toggled #content-wrapper {
        position: relative;
        margin-right: 250px;
      }
    }

    @media (max-width: 767px) {
      #wrapper {
        padding-left: 0;
      }

      #sidebar-wrapper {
        width: 0;
      }

      #wrapper.toggled #sidebar-wrapper {
        width: 250px;
      }

      #wrapper.toggled #navbar-wrapper {
        position: absolute;
        margin-right: -250px;
      }

      #wrapper.toggled #content-wrapper {
        position: absolute;
        margin-right: -250px;
      }

      #navbar-wrapper {
        position: relative;
      }

      #wrapper.toggled {
        padding-left: 250px;
      }

      #content-wrapper {
        position: relative;
        top: 0;
      }

      #wrapper.toggled #navbar-wrapper,
      #wrapper.toggled #content-wrapper {
        position: relative;
        margin-right: 250px;
      }
    }
  </style>



<body>
  
<aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <h2>DASHBOARD</h2>
      </div>
      <ul class="sidebar-nav">
        <li class="active">
          <a href="#"><i class="fa fa-home"></i>Blogs</a>
        </li>

        <?php
        if(isset($_SESSION['user_data'])){
          $admin = $_SESSION['user_data']['2'];
        } 
        if ($admin==1){
        ?>
        <li>
          <a href="category.php"><i class="fa fa-plug"></i>Category</a>
        </li>
        <li>
          <a href="users.php"><i class="fa fa-user"></i>Users</a>
        </li>
    <?php } ?>
        <li>
          <a href="home.php"><i class="fa fa-user"></i>Home</a>
        </li>
        <li>
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
              <?php
              if (isset($_SESSION['user_data'])) {
                echo $_SESSION['user_data']['1'];
              }
              ?>
            </span>
          </a>
        </li>
        <br>
        <button type="button" class="btn btn-outline-danger" style="margin-left: 25%;"><a href="logout.php">logout</a></button>
      </ul>

    </aside>
    <div id="navbar-wrapper">
      <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
          </div>
          <div class="collapse1" id="navbarSupportedContent">
            <nav class="navbar">
              <div>
                <a class="nav-link" href="#" id="userDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?php
                    if (isset($_SESSION['user_data'])) {
                      echo $_SESSION['user_data']['1'];
                    }
                    ?>
                  </span>
                </a>
              </div>
              <div>
                <button type="button" class="btn btn-outline-danger" style="background-color: red;"><a href="logout.php">logout</a></button>
              </div>
            </nav>
          </div>
        </div>
      </nav>
    </div>


    <div class="container my-8" style="margin-left: 10%; padding: 15%; margin-top: -15%;">
        <h1 class="text-center">WELCOME TO UPDATE PORTION</h1>


        <?php if (isset($row)) : ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $id; ?>" method="post" enctype="multipart/form-data">

                <div class="mb-3 mt-3">
                    <input type="hidden" class="form-control" value="<?php echo $row['id']; ?>" id="id" name="id">
                </div>

                <div class="mb-3 mt-3">
                    <label for="name">Title:</label>
                    <input type="text" class="form-control" value="<?php echo $row['title']; ?>" id="title" placeholder="Enter title" name="title">
                </div>
                <div class="mb-3 mt-3">
                    <label for="descript">description:</label>
                    <input type="text" class="form-control" value="<?php echo $row['descript']; ?>" id="descript" placeholder="Enter descript" name="descript">
                </div>

                <div class="mb-3">
                <select name="category" class="form-control" required>
                    

                    <?php while ($rows = mysqli_fetch_assoc($cat_result)) { ?>

                          <option value="<?php echo $rows['cat_name']; ?>"

                          <?=($rows['cat_name']==$rows['cat_name'])?"
                          selected": '';?>>
                            <?php echo $rows['cat_name']; ?>
                            </option>

                        <?php } ?>
                </select>
                </div>

                <div class="mb-3 mt-3">
                    <label for="publish">Publish:</label>
                    <select name="" id="" class="form-control">
                    <option value="draft">Draft</option>
                    <option value="publish">Publish</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tages">Tags:</label>
                    <select name="tags[]" id="tags" class="form-control" multiple>
                        <option value="php">PHP</option>
                        <option value="Java">Java</option>
                        <option value="js">JS</option>
                        <option value="python">python</option>
                      </select>
                </div>
                <div class="mb-3">
                    <label for="file">File:</label>
                    <input type="file" class="form-control" id="file" name="file">
                    <input type="hidden" name="old-file" value="<?php echo $row['file']; ?>">
                    <img src="upload/<?= $row['file']; ?>" width="100px" alt="image">
                </div>
                
                <button type="submit" class="btn btn-danger" name="update">Update</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><a href="admin.php">Close</a></button>
            </form>
        <?php else : ?>
            <p>No record available</p>
        <?php endif; ?>
    </div>


    
    <script>
    new MultiSelectTag('tags') // id
  </script>
  
</body>

</html>