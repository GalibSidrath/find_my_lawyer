<?php
session_start();
include 'utils/connection.php';
$isLogin = false;
if (isset($_SESSION['user_type']) && isset($_SESSION['user_email'])) {
    if ($_SESSION['user_type'] != 'lawyer_user') {
        $isLogin = true;
    }
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
    <style>
        .search-bar {
            margin: 5% auto;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="index.html">Find My Lawyer</a>

            <!-- Toggler for mobile view -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
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


    <!-- Search Form  -->

    <div class="container bg-light my-2">
        <div class="search-bar d-flex justify-content-around align-items-center">
            <form method="POST">
                <div class="row">
                    <div class="col-md-3">
                        <!-- Experience  -->
                        <div class="mb-3">
                            <label for="experience" class="form-label">Years of Experience</label>
                            <select class="form-select" name="experience" id="district" required>
                                <option value="" disabled selected>Select... </option>
                                <!-- District Options -->
                                <?php
                                for ($i = 1; $i < 9; $i++) {
                                    ?>
                                    <option value="<?php echo $i ?>"><?php echo $i ?> Years </option>
                                    <?php
                                }
                                ?>
                                <option value="10">10+ Years</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <!-- District Dropdown -->
                        <div class="form-group">
                            <label for="district" class="form-label">District</label>
                            <select class="form-select" name="district" id="district" required>
                                <option value="" disabled selected>Select your district</option>
                                <!-- District Options -->
                                <?php
                                include 'utils/district.php';
                                foreach ($districts as $district) {
                                    echo "<option value=\"$district\">$district</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <!-- Expertise Dropdown -->
                        <div class="form-group">
                            <label for="expertise" class="form-label">Expertise</label>
                            <select class="form-select" name="expertise" id="expertise">
                                <option value="" disabled selected>Select Expertise</option>
                                <option value="Criminal">Criminal Lawyer</option>
                                <option value="Corporate">Corporate Lawyer</option>
                                <option value="Family">Family Lawyer</option>
                                <option value="Immigration">Immigration Lawyer</option>
                                <option value="Tax">Tax Lawyer</option>
                                <option value="Civil Litigation">Civil Litigation Lawyer</option>
                                <option value="Employment">Employment Lawyer</option>
                                <option value="Intellectual Property">Intellectual Property Lawyer</option>
                                <option value="Banking and Finance">Banking and Finance Lawyer</option>
                                <option value="Real Estate">Real Estate Lawyer</option>
                                <option value="Constitutional">Constitutional Lawyer</option>
                                <option value="Environmental">Environmental Lawyer</option>
                                <option value="Human Rights">Human Rights Lawyer</option>
                                <option value="Public Interest">Public Interest Lawyer</option>
                                <option value="Consumer Protection">Consumer Protection Lawyer</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <!-- Search Button -->
                        <div class="form-group">
                            <label class="form-label d-block">&nbsp;</label> <!-- Blank label for alignment -->
                            <button type="submit" name="search" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>







    <div class="container my-5">
        <h1 class="text-start mb-4">Most Experienced Lawyers...</h1>
        <div class="row">
            <div class="col-md-9">
                <div class="row g-4">
                    <?php
                    $search_lawyer = "SELECT `id`, `name`, `email`, `phone`, `education`, `district`, `expertise`, `experience`, `address`FROM lawyer_user ORDER BY `experience` DESC LIMIT 50";
                    $search_lawyer_query_exe = mysqli_query($con, $search_lawyer);
                    while ($res = mysqli_fetch_assoc($search_lawyer_query_exe)) {
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
                                    <?php
                                    if (isset($_SESSION['user_email']) && isset($_SESSION['user_type'])) {
                                        ?>
                                        <a href="confirm_booking.php?lawyer_mail=<?php echo urlencode($res['email']); ?>&client_email=<?php echo urlencode($_SESSION['user_email']); ?>"
                                            class="btn btn-primary w-100 <?php
                                            if (!$isLogin) {
                                                echo 'disabled';
                                            }
                                            ?>">Proceed for Appointment</a>
                                        <?php
                                    } else {
                                        ?>
                                        <a id="myLink" href="" class="btn btn-primary w-100
                                            ?>">Proceed for Appointment</a>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <!-- Lawyer categories -->
            <div class="col-md-3">
                <h5 class="mb-3">Lawyer By Expertise</h5>
                <ul class="list-group">
                    <li class="list-group-item"><a
                            href="search_result_lawyer.php?field=<?php echo 'Criminal'; ?>&from_cat=true"
                            class="text-decoration-none">Criminal Lawyer</a></li>
                    <li class="list-group-item"><a
                            href="search_result_lawyer.php?field=<?php echo 'Corporate'; ?>&from_cat=true"
                            class="text-decoration-none">Corporate Lawyer</a></li>
                    <li class="list-group-item"><a
                            href="search_result_lawyer.php?field=<?php echo 'Family'; ?>&from_cat=true"
                            class="text-decoration-none">Family Lawyer</a></li>
                    <li class="list-group-item"><a
                            href="search_result_lawyer.php?field=<?php echo 'Immigration'; ?>&from_cat=true"
                            class="text-decoration-none">Immigration Lawyer</a></li>
                    <li class="list-group-item"><a
                            href="search_result_lawyer.php?field=<?php echo 'Tax'; ?>&from_cat=true"
                            class="text-decoration-none">Tax Lawyer</a></li>
                    <li class="list-group-item"><a
                            href="search_result_lawyer.php?field=<?php echo 'Civil Litigation'; ?>&from_cat=true"
                            class="text-decoration-none">Civil Litigation Lawyer</a></li>
                    <li class="list-group-item"><a
                            href="search_result_lawyer.php?field=<?php echo 'Employment'; ?>&from_cat=true"
                            class="text-decoration-none">Employment Lawyer</a></li>
                    <li class="list-group-item"><a
                            href="search_result_lawyer.php?field=<?php echo 'Intellectual Property'; ?>&from_cat=true"
                            class="text-decoration-none">Intellectual Property Lawyer</a></li>
                    <li class="list-group-item"><a
                            href="search_result_lawyer.php?field=<?php echo 'Banking and Finance'; ?>&from_cat=true"
                            class="text-decoration-none">Banking and Finance Lawyer</a></li>
                    <li class="list-group-item"><a
                            href="search_result_lawyer.php?field=<?php echo 'Real Estate'; ?>&from_cat=true"
                            class="text-decoration-none">Real Estate Lawyer</a></li>
                    <li class="list-group-item"><a
                            href="search_result_lawyer.php?field=<?php echo 'Constitutional'; ?>&from_cat=true"
                            class="text-decoration-none">Constitutional Lawyer</a></li>
                    <li class="list-group-item"><a
                            href="search_result_lawyer.php?field=<?php echo 'Environmental'; ?>&from_cat=true"
                            class="text-decoration-none">Environmental Lawyer</a></li>
                    <li class="list-group-item"><a
                            href="search_result_lawyer.php?field=<?php echo 'Human Rights'; ?>&from_cat=true"
                            class="text-decoration-none">Human Rights Lawyer</a></li>
                    <li class="list-group-item"><a
                            href="search_result_lawyer.php?field=<?php echo 'Public Interest'; ?>&from_cat=true"
                            class="text-decoration-none">Public Interest Lawyer</a></li>
                    <li class="list-group-item"><a
                            href="search_result_lawyer.php?field=<?php echo 'Consumer Protection'; ?>&from_cat=true"
                            class="text-decoration-none">Consumer Protection Lawyer</a></li>

                </ul>
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

    <script>
        document.getElementById('myLink').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the default link behavior
            alert('You must be log in before making an appointment.');
        });
    </script>

</body>

</html>
<?php
include 'login.php';
?>

<?php
if (isset($_POST["search"])) {
    // Retrieve and encode the POST values
    $experience = urlencode($_POST['experience']);
    $district = urlencode($_POST['district']);
    $expertise = urlencode($_POST['expertise']);

    // Redirect to the results page with the parameters
    echo "<script>
    location.replace('search_result_lawyer.php?experience={$experience}&district={$district}&expertise={$expertise}&from_cat=false');
    </script>";
}
?>