<?php
include('connect.php');
session_start();

if (isset($_SESSION['user_data'])) {
    $author_id = $_SESSION['user_data']['0'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Blog Home</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="favicon.ico" />

    <!-- Box icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="styless.css" rel="stylesheet" />

</head>
<body>
<header>
        <!-- Responsive navbar-->
        <div class="nav container">
            <a href="home.php" class="logo">Be<span>logger</span></a>
            <div class="collapse1" id="navbarSupportedContent">
                <nav class="navbar">
                    <a href="#home" class="active">Home</a>
                    <a href="#about">About</a>
                    <a href="#blogs">Blogs</a>
                    <a href="#contact">Contact</a>
                    <button type="button" class="login1" onclick="location.href='login.php'">Login</button>
                </nav>
            </div>
        </div>
    </header>


    <section class="blogs" id="blogs">
        <!-- categories bar -->
        <div class="main-container" >
            <div class="rowed">

                <!-- Side widgets-->
                <div class="Side-widgets1">
                    <!-- Categories widget-->
                    <?php
                    include('connect.php');
                    $sql = "SELECT * from categories";
                    $query = mysqli_query($conn, $sql);

                    ?>

                    <h2 class="heading2">Blogs</h2>
                    <div class="card">
                        <div class="card-header">Categories</div>
                        <div class="card-body">
                            <div class="row2">
                                <div class="col-sm-3">
                                    <ul class="list-unstyled">
                                        <?php while ($cats = mysqli_fetch_assoc($query)) { ?>
                                            <li>
                                                <a href="">
                                                    <!-- homeCategory.php?id=<?php echo $cats['cat_id'] ?> -->
                                                    <?php echo $cats['cat_name'] ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blog entries-->
                <div class="col-lg-8">

                    <div class="row1">
                        <div class="col-lg-15">
                            <!-- Blog post-->
                            <?php
                            include('connect.php');
                            // pagination
                            if (!isset($_GET['page'])) {
                                $page = 1;
                            } else {
                                $page = $_page = $_GET['page'];
                            }
                            $limit = 5;
                            $offset = ($page - 1) * $limit;
                            //=======================

                            $sql = "SELECT * FROM posts 
                        LEFT JOIN categories ON posts.category = categories.cat_id 
                        LEFT JOIN users ON posts.author_id = users.user_id 
                        WHERE posts.publish = 'publish' 
                        ORDER BY posts.date DESC limit $offset,$limit";

                            $run = mysqli_query($conn, $sql);
                            $row = mysqli_num_rows($run);

                            if ($row) {
                                while ($result = mysqli_fetch_assoc($run)) {
                            ?>
                                    <div class="post-container">
                                        <div class="post-box" style="width: 120%;">
                                            <div class="post-img">
                                                <a href="#!" class="pt-img">
                                                    <?php $img = $result['file'] ?>
                                                    <img src="upload/<?= $img ?>" alt='image'>
                                                </a>
                                            </div>
                                            <div class="flex-grow-1 flex-part2">
                                                <h1 class="card-title h4"><?php echo ucfirst($result['title']) ?></h1>

                                                <p class="card-text">
                                                    <a>
                                                        <?php echo strip_tags(substr($result['descript'], 0, 200)) . "..." ?>
                                                    </a>
                                                    <span> <br>
                                                        <a class="btn btn-sm btn-outline-primary" href="single_post.php? id= <?php echo $result['id'] ?>">Read more →</a>
                                                    </span>
                                                </p>
                                                <div style="display: flex;">
                                                    <div class="me-2">
                                                        <a>
                                                            <span>
                                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                            </span>
                                                            <?php echo $result['username'] ?>
                                                        </a>
                                                    </div>
                                                    <div class="me-2">
                                                        <a>
                                                            <span>
                                                                <i class="fa fa-calender-o" aria-hidden="true"></i>
                                                            </span>
                                                            <?php echo $result['date']  ?>
                                                        </a>
                                                    </div>
                                                    <div class="category">
                                                        <a>
                                                            <span>
                                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                            </span>
                                                            <?php echo $result['category']  ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                            <?php }
                            } ?>
                            <!-- Blog post-->

                        </div>

                    </div>
                    <!-- Pagination-->
                    <?php
                    $pagination = "SELECT * from posts";
                    $run_q = mysqli_query($conn, $pagination);
                    $total_post = mysqli_num_rows($run_q);
                    $pages = ceil($total_post / $limit);
                    if($total_post>$limit){
                    ?>
                    <nav aria-label="Pagination">
                        <hr class="my-0" />
                        <ul class="pagination justify-content-center my-4">

                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                <li class="page-item <?= ($i == $page) ?  $active = "active" : ""; ?>" aria-current="page">
                                    <a class="page-link" href="blogs.php?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php } ?>

                        </ul>
                    </nav>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
</body>