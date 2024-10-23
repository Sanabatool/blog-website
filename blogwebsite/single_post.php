<?php
include('connect.php');

$message = "";
$scroll = false;
if (isset($_POST['submit'])) {
    $comment = $_POST['comment'];

    $sqlcomm = "INSERT into reviews(`comment`) Values('$comment')";

    $resultcom = mysqli_query($conn, $sqlcomm);

    if ($resultcom) {
        $message = "Thanks For Your Response!";
    } else {
        $message = "Try again";
    }
    $scroll = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Blog Home</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/> -->
    <!-- <link href="styless.css" rel="stylesheet" /> -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<style>
    * {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        scroll-behavior: smooth;
        box-sizing: border-box;
    }

    ::selection {
        color: var(--bg-color);
        background: var(--second-color);
    }

    a {
        text-decoration: none;
    }

    img {
        display: block;
        width: 100%;
        object-fit: cover;
    }

    .banner-image {
        margin: 10px;
        width: 40rem;
    }

    .card {
        margin-bottom: 10%;
    }

    .commentform {
        margin-top: -5%;
    }

    /* ============================footer============================ */
    .footer-widget p {
        margin-bottom: 27px;
    }

    p {
        font-family: 'Nunito', sans-serif;
        font-size: 16px;
        color: #878787;
        line-height: 28px;
    }

    .animate-border {
        position: relative;
        display: block;
        width: 115px;
        height: 3px;
        background: #007bff;
    }

    .animate-border:after {
        position: absolute;
        content: "";
        width: 35px;
        height: 3px;
        left: 0;
        bottom: 0;
        border-left: 10px solid #fff;
        border-right: 10px solid #fff;
        animation: animborder 2s linear infinite;
    }

    @-webkit-keyframes animborder {
        0% {
            transform: translateX(0px);
        }

        100% {
            -webkit-transform: translateX(113px);
            transform: translateX(113px);
        }
    }

    @keyframes animborder {
        0% {
            transform: translateX(0px);
        }

        100% {
            -webkit-transform: translateX(113px);
            transform: translateX(113px);
        }
    }

    .animate-border.border-white:after {
        border-color: #fff;
    }

    .animate-border.border-yellow:after {
        border-color: #F5B02E;
    }

    .animate-border.border-orange:after {
        border-right-color: #007bff;
        border-left-color: #007bff;
    }

    .animate-border.border-ash:after {
        border-right-color: #EEF0EF;
        border-left-color: #EEF0EF;
    }

    .animate-border.border-offwhite:after {
        border-right-color: #F7F9F8;
        border-left-color: #F7F9F8;
    }

    /* Animated heading border */
    @keyframes primary-short {
        0% {
            width: 15%;
        }

        50% {
            width: 90%;
        }

        100% {
            width: 10%;
        }
    }

    @keyframes primary-long {
        0% {
            width: 80%;
        }

        50% {
            width: 0%;
        }

        100% {
            width: 80%;
        }
    }

    .dk-footer {
        padding: 75px 0 0;
        background-color: #151414;
        position: relative;
        z-index: 2;
    }

    .dk-footer .contact-us {
        margin-top: 0;
        margin-bottom: 30px;
        padding-left: 80px;
    }

    .dk-footer .contact-us .contact-info {
        margin-left: 50px;
    }

    .dk-footer .contact-us.contact-us-last {
        margin-left: -80px;
    }

    .dk-footer .contact-icon i {
        font-size: 24px;
        top: -15px;
        position: relative;
        color: #007bff;
    }

    .dk-footer-box-info {
        background: #202020;
        padding: 40px;
        z-index: 2;
    }

    .dk-footer-box-info .footer-social-link h3 {
        color: #fff;
        font-size: 24px;
        margin-bottom: 5px;
    }

    .dk-footer-box-info .footer-social-link ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .dk-footer-box-info .footer-social-link li {
        display: inline-block;
    }

    .dk-footer-box-info .footer-social-link a i {
        display: block;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        text-align: center;
        line-height: 40px;
        background: #000;
        margin-right: 5px;
        color: #fff;
    }

    .dk-footer-box-info .footer-social-link a i.fa-facebook {
        background-color: #3B5998;
    }

    .dk-footer-box-info .footer-social-link a i.fa-twitter {
        background-color: #55ACEE;
    }

    .dk-footer-box-info .footer-social-link a i.fa-google-plus {
        background-color: #DD4B39;
    }

    .dk-footer-box-info .footer-social-link a i.fa-linkedin {
        background-color: #0976B4;
    }

    .dk-footer-box-info .footer-social-link a i.fa-instagram {
        background-color: #B7242A;
    }

    .footer-info-text {
        margin: 26px 0 32px;
    }

    .footer-left-widget {
        padding-left: 80px;
    }

    .footer-widget .section-heading {
        margin-bottom: 35px;
    }

    .footer-widget h3 {
        font-size: 24px;
        color: #fff;
        position: relative;
        margin-bottom: 15px;
        max-width: -webkit-fit-content;
        max-width: -moz-fit-content;
        max-width: fit-content;
    }

    .footer-widget ul {
        width: 50%;
        float: left;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .footer-widget li {
        margin-bottom: 18px;
    }

    .footer-widget p {
        margin-bottom: 27px;
    }

    .footer-widget a {
        color: #878787;
        -webkit-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
    }

    .footer-widget a:hover {
        color: #007bff;
    }

    .footer-widget:after {
        content: "";
        display: block;
        clear: both;
    }

    .dk-footer-form {
        position: relative;
    }

    .dk-footer-form input[type=email] {
        padding: 14px 28px;
        border-radius: 50px;
        background: #2E2E2E;
        border: 1px solid #2E2E2E;
    }

    .dk-footer-form input::-webkit-input-placeholder,
    .dk-footer-form input::-moz-placeholder,
    .dk-footer-form input:-ms-input-placeholder,
    .dk-footer-form input::-ms-input-placeholder,
    .dk-footer-form input::-webkit-input-placeholder {
        color: #878787;
        font-size: 14px;
    }

    .dk-footer-form input::-webkit-input-placeholder,
    .dk-footer-form input::-moz-placeholder,
    .dk-footer-form input:-ms-input-placeholder,
    .dk-footer-form input::-ms-input-placeholder,
    .dk-footer-form input::placeholder {
        color: #878787;
        font-size: 14px;
    }

    .dk-footer-form button[type=submit] {
        position: absolute;
        top: 0;
        right: 0;
        padding: 12px 24px 12px 17px;
        border-top-right-radius: 25px;
        border-bottom-right-radius: 25px;
        border: 1px solid #007bff;
        background: #007bff;
        color: #fff;
    }

    .dk-footer-form button:hover {
        cursor: pointer;
    }

    /* ==========================

  Contact

=============================*/
    .contact-us {
        position: relative;
        z-index: 2;
        margin-top: 65px;
        display: -webkit-box;
        display: -webkit-flex;
        display: -moz-box;
        display: -ms-flexbox;
        display: flex;
        align-items: center;
    }

    .contact-icon {
        position: absolute;
    }

    .contact-icon i {
        font-size: 36px;
        top: -5px;
        position: relative;
        color: #007bff;
    }

    .contact-info {
        margin-left: 75px;
        color: #fff;
    }

    .contact-info h3 {
        font-size: 20px;
        color: #fff;
        margin-bottom: 0;
    }
</style>

<body>

    <?php
    include('connect.php');
    $sql = "SELECT * from categories";
    $query = mysqli_query($conn, $sql);

    ?>

    <section>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid" style="background-color: black;">
                <a class="navbar-brand" href="home.php">Bloggers</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#!" role="button" aria-haspopup="true" aria-expanded="false">Categories</a>
                            <div class="dropdown-menu">
                                <?php while ($cats = mysqli_fetch_assoc($query)) { ?>
                                    <a class="dropdown-item" href="#"><?php echo $cats['cat_name'] ?></a>
                                <?php } ?>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Blog</a></li>
                        <li class="nav-item">
                            <button type="button" class="btn btn-primary" onclick="location.href='login.php'">Login</button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </section>


    <section>
        <div class="container mt-2">
            <div class="row">
                <div class="col-lg-8">
                    <?php include('connect.php');

                    $id = $_GET['id'];

                    $sql = "SELECT * FROM posts where id = '$id'";
                    $result = mysqli_query($conn, $sql);
                    $post = mysqli_fetch_assoc($result);

                    ?>
                    <div class="card shadow">
                        <div class="card-body" style="width: 100%; height: 80rem;">
                            <div class="banner-image" id="single_img">
                                <?php $img = $post['file'] ?>
                                <a href="#!">
                                    <img src="upload/<?php echo $img ?>" alt="" style="width: 100%;">
                                </a>
                            </div>
                            <hr>
                            <div class="para">
                                <h5><?php echo ucfirst($post['title']) ?></h5>
                                <p><?php echo $post['descript'] ?></p>
                            </div>
                        </div>
                    </div>
                    <?php  ?>
                </div>

                <!-- Side widgets-->
                <div class="col-lg-4">
                    <!-- Search widget-->
                    <div class="card mb-4">
                        <div class="card-header2">Search</div>
                        <div class="card-body">
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                                <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                            </div>
                        </div>
                    </div>

                    <!-- Categories widget-->
                    <?php
                    include('connect.php');
                    $sql = "SELECT * from categories";
                    $query = mysqli_query($conn, $sql);

                    //recent posts
                    $sql2 = "SELECT * from posts ORDER BY date limit 5";
                    $query2 = mysqli_query($conn, $sql2);

                    ?>
                    <div class="card mb-4">
                        <div class="card-header2">Categories</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <ul class="list-unstyled2 mb-0">
                                        <?php while ($cats = mysqli_fetch_assoc($query)) { ?>
                                            <li>
                                                <a href="cat.php?id=<?php echo $cats['cat_id'] ?>" class="text-success fw-bold">
                                                    <?php echo $cats['cat_name'] ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Side widget-->
                    <div class="card mb-4">
                        <div class="card-header2">Recent Posts</div>
                        <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
                        <ul>
                            <?php while ($posts = mysqli_fetch_assoc($query2)) { ?>
                                <li>
                                    <a href="single_post.php?id=<?= $posts['id'] ?>" class="text-success fw-bold"><?= $posts['title']; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section style="margin-left: 10%;" class="commentform">
        <div class="cantainer">
            <div class="row mb-3">
                <div class="col-11">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Comment Box</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="comment"></textarea>
                        </div>
                        <div id="message">
                            <?php
                            if ($message != "") {
                                echo $message;
                            }
                            ?>
                        </div>
                        <div>
                            <input class="btn btn-primary" type="submit" value="Submit" name="submit">
                        </div>
                    </form>
                    <?php
                    // Inline JavaScript to scroll to the form after submission
                    if ($scroll) {
                        echo "<script>
        document.querySelector('textarea').scrollIntoView({ behavior: 'smooth' });
    </script>";
                    }
                    ?>
                </div>
            </div>
        </div>

    </section>




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

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="scripts.js"></script>
</body>