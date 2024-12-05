<?php
include 'utils/connection.php';
session_start();
$isLogin = false;
if (isset($_SESSION['user_type']) && isset($_SESSION['user_email'])) {
    $isLogin = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find My Lawyer</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="index.php">Find My Lawyer</a>

            <!-- Toggler for mobile view -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="all_lawyers.php">All Lawyers</a>
                    </li>
                    <?php
                    if (isset($_SESSION['user_type']) && isset($_SESSION['user_email'])) {
                        if ($_SESSION['user_type'] == 'general_user') {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="user_profile.php">Profile</a>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if ($_SESSION['user_type'] == 'lawyer_user') {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="lawyer_profile.php">Profile</a>
                            </li>
                            <?php
                        }
                    }

                    ?>
                </ul>
                <!-- Login and Signup buttons -->
                <div class="d-flex ms-lg-3">
                    <!-- Login Button -->
                    <?php
                    if (isset($_SESSION['user_email']) && isset($_SESSION['user_type'])) {
                        ?>
                        <a href="logout.php" class="btn btn-danger">Log out</a>
                        <?php
                    } else {
                        ?>
                        <button type="button" class="btn btn-outline-light me-2" data-bs-toggle="modal"
                            data-bs-target="#loginModal">Login</button>
                        <a href="lawyer_signup.php" class="btn btn-light mx-1">Signup as Lawyer</a>
                        <a href="normal_user_signup.php" class="btn btn-light">Signup as Normal User</a>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </nav>








    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row g-4">
                    <?php
                    $from_cat = $_GET['from_cat'];

                    if ($from_cat == 'true') {
                        $field = mysqli_real_escape_string($con, $_GET['field']); // Sanitize input
                        $search = "SELECT * FROM `lawyer_user` WHERE `expertise`='$field'";
                    }

                    if ($from_cat == 'false') {
                        $experience = mysqli_real_escape_string($con, $_GET['experience']);
                        $district = mysqli_real_escape_string($con, $_GET['district']);
                        $expertise = mysqli_real_escape_string($con, $_GET['expertise']);
                        if ($experience > 9) {
                            $search = "SELECT * FROM `lawyer_user` WHERE `expertise`='$expertise' AND `district`='$district' AND `experience` >= 10";
                        }else{
                        $search = "SELECT * FROM `lawyer_user` WHERE `expertise`='$expertise' AND `district`='$district' AND `experience`='$experience'";
                        }
                    }

                    if ($search != null) {
                        $search_query_exe = mysqli_query($con, $search);
                        while ($res = mysqli_fetch_array($search_query_exe)) {
                            ?>
                            <!-- Card -->
                            <div class="col-md-4">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $res['name']; ?></h5>
                                        <h6 class="card-subtitle mb-2 text-muted"><?php echo $res['expertise']; ?> Lawyer</h6>
                                        <p class="card-text">
                                            <strong>Experience:</strong> <?php echo $res['experience']; ?> years<br>
                                            <strong>Education:</strong> <?php echo $res['education']; ?><br>
                                            <strong>Chamber:</strong> <?php echo $res['address']; ?><br>
                                            <strong>Phone:</strong> <?php echo $res['phone']; ?>
                                        </p>
                                        <a href="confirm_booking.php" class="btn btn-primary w-100 <?php
                                    if (!$isLogin) {
                                        echo 'disabled';
                                    }
                                    ?>">Proceed for Appointment</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>

                </div>
            </div>


        </div>

    </div>



     <!-- Modal for Login -->
     <?php 
        include 'modal.php';
    ?>



    <!-- Bootstrap JS and Bootstrap Icons CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>

</body>

</html>

<?php 
    include 'login.php';
?>