<?php
include('connect.php');
session_start();

// Security check
if (!isset($_SESSION['user_data'])) {
  header("location: http://localhost/blogwebsite/login.php");
}

if (isset($_SESSION['user_data'])) {
  $author_id = $_SESSION['user_data']['0'];
}

if (isset($_POST['publish'])) {
  $title = $_POST['title'];
  $description = $_POST['descript'];
  $category = $_POST['category'];
  $tags = isset($_POST['tags']) ? $_POST['tags'] : [];
  $publish = $_POST['status'];

  $image = $_FILES['file']['name'];
  $tmp_name = $_FILES['file']['tmp_name'];
  $image_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
  $allow_type = ['jpg', 'png', 'jfif'];
  $destination = "upload/" . $image;

  if (in_array($image_ext, $allow_type)) {
    move_uploaded_file($tmp_name, $destination);

    // Concatenate tags into a single string
    $tags_string = implode(',', $tags);

    // Insert post
    $sql1 = "INSERT INTO `posts` (title, descript, category, publish, tags, file, author_id) VALUES ('$title', '$description', '$category', '$publish', '$tags_string', '$image', '$author_id')";
    $result1 = mysqli_query($conn, $sql1);

    if (!$result1) {
      die("Error inserting post: " . mysqli_error($conn));
    }
  } else {
    die("Unsupported file type.");
  }
}


$cat_sql = "SELECT * from `categories`";
$cat_result = mysqli_query($conn, $cat_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/css/multi-select-tag.css">

  <!--font awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>admin page</title>
  <script src="https://cdn.ckeditor.com/4.24.0-lts/standard/ckeditor.js"></script>
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
</head>

<body>
  <header>

  </header>
  <div id="wrapper">

    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <h2>DASHBOARD</h2>
      </div>
      <ul class="sidebar-nav">
        <li class="active">
          <a href="#"><i class="fa fa-home"></i>Blogs</a>
        </li>

        <?php
        if (isset($_SESSION['user_data'])) {
          $admin = $_SESSION['user_data']['2'];
        }
        if ($admin == 1) {
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
          <a href="reviews.php"><i class="fa fa-user"></i>Reviews</a>
        </li>
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
    <!-- ====================================================================== -->
    <section id="content-wrapper">
      <div class="container my-8">
        <h1 class="text-center">BLOGS PAGE</h1>
        <div class="container ">
          <div class="my-5" id="displayDataTable"></div>
        </div>
        <button1 type="button" class="btn btn-dark my-4" data-bs-toggle="modal" data-bs-target="#completeModal">
          Add New Blog
        </button1>


        <?php
        if (isset($_SESSION['status-image']) && $_SESSION != '') {
        ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Hey!</strong> <?php echo $_SESSION['status-image']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php
          unset($_SESSION['status-image']);
        }
        ?>


        <!--search line-->
        <div class="container mt-3">
          <div class="row mb-6">
            <div class="col-11">
              <form action="" method="GET">
                <div class="input-group ">
                  <div class="input-group-prepend ">
                    <button type="submit" class="input-group-text bg-dark " name="search"><i class="fas fa-search text-light my-2"></i></button>

                  </div>
                  <input type="text" class="form-control " placeholder="search user..." name="search">
                </div>
              </form>
            </div>
          </div>
        </div>


        <!-- Modal    enctype: yaha q k hum post k sath file method bhi use karenge -->
        <form action="" method="post" enctype="multipart/form-data">
          <div class="modal fade" id="completeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title" id="exampleModalLabel">New Blog</h1>
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">

                  <div class="input-group">
                    <input type="hidden" name="id">
                  </div>

                  <div class="form-group">
                    <label for="completename">Title</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-dark">
                          <i class="fas fa-user-alt text-light my-2"></i></span>
                      </div>
                      <input type="text" class="form-control" id="completename" name="title">
                    </div>

                  </div>

                  <div class="form-group">
                    <label for="completeemail">Description</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-dark">
                          <i class="fas fa-envelope-open text-light my-2"></i></span>
                      </div>
                      <textarea type="text" class="form-control" id="completeemail" name="descript" rows="3" required></textarea>
                      <script>
                        CKEDITOR.replace( 'descript' );
                </script>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="completemobile">Category</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-dark">
                          <i class="fas fa-phone text-light my-2"></i></span>
                      </div>
                      <select id="category" name="category" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php while ($row = mysqli_fetch_assoc($cat_result)) { ?>
                          <option value="<?php echo $row['cat_name']; ?>"><?php echo $row['cat_name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="publish">Is Publish</label>
                    <div class="input-group">
                      <span class="input-group-text bg-dark">
                        <i class="fas fa-envelope-open text-light my-2"></i></span>
                      <select name="status" id="publish" class="form-control">

                        <option value="draft"
                          <?php if (($post['publish'] ?? '') == 'draft') echo 'selected'; ?>>Draft</option>
                        <option value="publish" <?php if (($post['publish'] ?? '') == 'published') echo 'selected'; ?>>Published</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="tags">Select Tags:</label>
                    <div class="input-group">
                      <select name="tags[]" id="tags" class="form-control" multiple>
                        <option value="php">Designers</option>
                        <option value="Java">Players</option>
                        <option value="js">Students</option>
                        <option value="python">Fashion</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="completefile">File</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-dark">
                          <i class="fas fa-solid fa-location-dot text-light my-2"></i></span>
                      </div>
                      <input type="file" class="form-control" id="completedept" name="file">
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-dark" data-bs-dismis="modal" name="publish">Add</button>
                </div>
              </div>
            </div>

          </div>
        </form>


        <div class="container mt-3">
          <h2>Blogs list</h2>
          <table class="table table-dark table-hover">
            <?php

              $sql = "SELECT posts.*,
                        categories.cat_name,
                        users.username,
                        GROUP_CONCAT(tags.tag_name SEPARATOR ', ') AS tags
                    FROM 
                        posts
                    LEFT JOIN 
                        categories ON posts.category = categories.cat_id
                    LEFT JOIN 
                        users ON posts.author_id = users.user_id
                    LEFT JOIN 
                        posts_tags ON posts.id = posts_tags.post_id
                    LEFT JOIN 
                        tags ON posts_tags.tag_id = tags.id WHERE $author_id=posts.author_id ";


            // Search query -> The isset function checks if the search parameter is present in the $_GET superglobal array.
            //ternary operator ? :
            if (isset($_GET['search']) && !empty($_GET['search'])) {
              $search = $_GET['search'];
              // Modify SQL query to include search condition
              $sql .= " AND posts.id LIKE '%$search%' OR posts.title LIKE '%$search%'";
          }  $sql .= " GROUP BY posts.id
            ORDER BY posts.date DESC";

            $result = mysqli_query($conn, $sql);
          
            if ($result->num_rows > 0) {
              echo '<table class="table table-dark table-hover">';

              echo "<tr>
            <th>S:No:</th>
            <th>Title</th>
            <th>Description</th>
            <th>Category</th>
            <th>Status</th>
            <th>File</th>
            <th>Author</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>";

              echo "<tbody>";
              //$result = mysqli_query($conn, $sql,);

                $i = 1;
              while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row["title"] . "</td>";
                echo '<td>' . strip_tags(substr($row['descript'], 0, 200)) . '...</td>';
                echo "<td>" . $row["category"] . "</td>";
                echo "<td>" . $row["publish"] . "</td>";
                echo "<td><img src='upload/" . $row['file'] . "' width='80px' height='100px' alt='image'></td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>
        <form action='update.php' method='get'>
            <input type='hidden' name='id' value='" . $row['id'] . "'>
            <button type='submit' class='btn btn-danger'>Update</button>
        </form>
      </td>";

                echo "<td>
        <form action='delete.php' method='post'>
            <input type='hidden' name='delete_id' value='" . $row['id'] . "'>
            <input type='hidden' name='del_image' value='" . $row['file'] . "'>
            <button type='submit' name='delete_imge' class='btn btn-danger'>Delete</button>
        </form>
      </td>";
                echo "</tr>";

                $i++;
              }
              echo "</tbody>";
              echo "</table>";
            } else {
              echo "0 results";
            }
            ?>


        </div>
      </div>

  </div>


  </section>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.1.0/dist/js/multi-select-tag.js"></script>

  <script>
    new MultiSelectTag('tags') // id
  </script>


  <script>
    const $button = document.querySelector('#sidebar-toggle');
    const $wrapper = document.querySelector('#wrapper');

    $button.addEventListener('click', (e) => {
      e.preventDefault();
      $wrapper.classList.toggle('toggled');
    });
  </script>




  <!-- ========================================================================= -->




  <!-- ========================================================================= -->


</body>

</html>