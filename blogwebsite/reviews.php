<?php
session_start();
include('connect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


  <!--font awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Document</title>
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


  <div id="wrapper">

    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <h2>DASHBOARD</h2>
      </div>
      <ul class="sidebar-nav">
        <li class="active">
          <a href="admin.php"><i class="fa fa-home"></i>Blogs</a>
        </li>



        <li>
          <a href="category.php"><i class="fa fa-plug"></i>Category</a>
        </li>
        <li>
          <a href="users.php"><i class="fa fa-user"></i>Users</a>
        </li>
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

    <!-- =========================================================== -->

    <section id="content-wrapper">
      <div class="container my-8">
        <h1 class="text-center">Reviews Section</h1>
        <div class="container ">
          <div class="my-5" id="displayDataTable"></div>
        </div>
      </div>

      <!-- ============================================================= -->

      <div class="container mt-3">
        <h2>Comments</h2>
        <table class="table table-dark table-hover">
          <?php

          $sql = "SELECT * FROM reviews";

          $result = mysqli_query($conn, $sql);

          if ($result->num_rows > 0) {
            echo '<table class="table table-dark table-hover">';

            echo "<tr>
            <th>S:No:</th>
            <th>Comments</th>
            <th>Delete</th>
        </tr>";

            echo "<tbody>";
            $i = 1;
            while ($row = mysqli_fetch_array($result)) {
              echo "<tr>";
              echo "<td>" . $i . "</td>";
              echo "<td>" . $row["comment"] . "</td>";

              echo "<td>
        <form action='reviews.php' method='post'>
            <input type='hidden' name='delete_id' value='" . $row['id'] . "'>
            <button type='submit' name='delete_imge' class='btn btn-danger'>Delete</button>
        </form>
      </td>";
              echo "</tr>";

              $i++;
            }
            echo "</tbody>";
          } else {
            echo "<tr><td colspan='3'>0 results</td></tr>";
          }
          ?>
        </table>

      </div>


    </section>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


</body>

</html>