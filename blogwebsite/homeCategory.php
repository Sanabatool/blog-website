<?php
include('connect.php');
$id = $_GET['id'] ?? '';
if(empty($id)){
  header("location: home.php");
  exit();
}

session_start();

if (isset($_SESSION['user_data'])) {
    $author_id = $_SESSION['user_data']['0'];
}

$id = mysqli_real_escape_string($conn, $id);
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

    <!-- ======================================================= -->

    <?php
    $sql = "SELECT * from categories";
    $query = mysqli_query($conn, $sql);
    ?>
    <header>
        <!-- Responsive navbar-->
        <div class="nav container">
            <a href="#" class="logo">Be<span>logger</span></a>
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
 
    <!-- <div class="post-filter container">
        <li class="nav-item dropdown">
            <a class="filter-item active-filter dropdown-toggle" data-filter='all' data-bs-toggle="dropdown" href="#!" role="button" aria-haspopup="true" aria-expanded="false">Categories</a>
            <div class="dropdown-menu">
               
            </div>
        </li>
    </div> -->

    <section class="blogs" id="blogs">
        <div class="main-container">
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
                                <div class="col-sm-5">
                                    <ul class="list-unstyled">
                                        <?php while ($cats = mysqli_fetch_assoc($query)) { ?>
                                            <li>
                                                <a href="cat.php?id=<?php echo $cats['cat_id'] ?>">
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

                <!-- Blog post -->
            <?php
            include('connect.php');

            // Query to fetch posts based on the selected category
            $sql = "SELECT * FROM posts 
                    LEFT JOIN categories ON posts.category = categories.cat_id 
                    LEFT JOIN users ON posts.author_id = users.user_id 
                    WHERE posts.publish = 'publish' AND categories.cat_id = '$id'
                    ORDER BY posts.date DESC";

            $run = mysqli_query($conn, $sql);
            $row = mysqli_num_rows($run);

            if ($row > 0) {
                while ($result = mysqli_fetch_assoc($run)) {
            ?>
                    <div class="post-container">
                        <div class="post-box" style="width: 120%;">
                            <div class="post-img">
                                <a href="#!">
                                    <?php $img = $result['file'] ?>
                                    <img src="upload/<?= $img ?>" height='200px' alt='image'>
                                </a>
                            </div>
                            <div class="flex-grow-1 flex-part2">
                                <h1 class="card-title h4"><?php echo ucfirst($result['title']) ?></h1>

                                <p class="card-text">
                                    <a>
                                        <?php echo strip_tags(substr($result['descript'], 0, 200)) . "..." ?>
                                    </a>
                                    <span> <br>
                                        <a class="btn btn-sm btn-outline-primary" href="single_post.php?id=<?php echo $result['id'] ?>">Read more →</a>
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
                                                <i class="fa fa-calendar-o" aria-hidden="true"></i>
                                            </span>
                                            <?php echo $result['date'] ?>
                                        </a>
                                    </div>
                                    <div class="category">
                                        <a>
                                            <span>
                                                <i class="fa fa-tag" aria-hidden="true"></i>
                                            </span>
                                            <?php echo $result['category'] ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No posts found in this category.</p>";
            }
            ?>
            <!-- Blog post -->
            </div>
        </div>
    </section>
    <!-- Footer-->
    <section id="contact">
    <footer id="dk-footer" class="dk-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-4">
                    <div class="dk-footer-box-info">
                        <a href="index.html" class="footer-logo">
                            <img src="https://cdn.pixabay.com/photo/2016/11/07/13/04/yoga-1805784_960_720.png" alt="footer_logo" class="img-fluid">
                        </a>
                        <p class="footer-info-text">
                           Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum generator.
                        </p>
                        <div class="footer-social-link">
                            <h3>Follow us</h3>
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-google-plus"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Social link -->
                    </div>
                </div>
                <!-- End Col -->
                <div class="col-md-12 col-lg-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="contact-us">
                                <div class="contact-icon">
                                    <i class="fa fa-map-o" aria-hidden="true"></i>
                                </div>
                                <!-- End contact Icon -->
                                <div class="contact-info">
                                    <h3>Pakistan</h3>
                                    <p>5353 Road Address</p>
                                </div>
                                <!-- End Contact Info -->
                            </div>
                            <!-- End Contact Us -->
                        </div>
                        <!-- End Col -->
                        <div class="col-md-6">
                            <div class="contact-us contact-us-last">
                                <div class="contact-icon">
                                    <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                                </div>
                                <!-- End contact Icon -->
                                <div class="contact-info">
                                    <h3>95 711 9 5353</h3>
                                    <p>Give us a call</p>
                                </div>
                                <!-- End Contact Info -->
                            </div>
                            <!-- End Contact Us -->
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Contact Row -->
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="footer-widget footer-left-widget">
                                <div class="section-heading">
                                    <h3>Useful Links</h3>
                                    <span class="animate-border border-black"></span>
                                </div>
                                <ul>
                                    <li>
                                        <a href="#">About us</a>
                                    </li>
                                    <li>
                                        <a href="#">Services</a>
                                    </li>
                                    <li>
                                        <a href="#">Projects</a>
                                    </li>
                                    <li>
                                        <a href="#">Our Team</a>
                                    </li>
                                </ul>
                                <ul>
                                    <li>
                                        <a href="#">Contact us</a>
                                    </li>
                                    <li>
                                        <a href="#">Blog</a>
                                    </li>
                                    <li>
                                        <a href="#">Testimonials</a>
                                    </li>
                                    <li>
                                        <a href="#">Faq</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Footer Widget -->
                        </div>
                        <!-- End col -->
                        <div class="col-md-12 col-lg-6">
                            <div class="footer-widget">
                                <div class="section-heading">
                                    <h3>Subscribe</h3>
                                    <span class="animate-border border-black"></span>
                                </div>
                                <p><!-- Don’t miss to subscribe to our new feeds, kindly fill the form below. -->
                                Reference site about Lorem Ipsum, giving information on its origins, as well.</p>
                                <form action="#">
                                    <div class="form-row">
                                        <div class="col dk-footer-form">
                                            <input type="email" class="form-control" placeholder="Email Address">
                                            <button type="submit">
                                                <i class="fa fa-send"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <!-- End form -->
                            </div>
                            <!-- End footer widget -->
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>
                <!-- End Col -->
            </div>
            <!-- End Widget Row -->
        </div>
        <!-- End Contact Container -->
</footer>

    </section>


    <!-- Core theme JS-->
    <script src="scripts.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    document.querySelectorAll('a[data-bs-toggle="dropdown"]').forEach(function(element) {
        element.addEventListener('click', function(event) {
            event.preventDefault();
        });
    });
</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

</html>