<?php
session_start();
include 'utils/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        .profile-section {
            margin-top: 5rem;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-light">
    <!-- Sticky Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">Find My Lawyer</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="user_profile.php">Profile</a>
                    </li>
                    <!-- Login and Signup buttons -->
                <div class="d-flex ms-lg-3">
                    <!-- Login Button -->
                    <?php
                    if (isset($_SESSION['user_email']) && isset($_SESSION['user_type'])) {
                        ?>
                        <a href="logout.php" class="btn btn-danger">Log out</a>
                        <?php
                    }
                    ?>

                </div>
                </ul>
            </div>
        </div>
    </nav>

    <!-- User Details Section -->
    <div class="container my-5">
        <div class="profile-section">
            <?php
            $search = "SELECT * FROM `general_user` WHERE `email` = '{$_SESSION['user_email']}'";
            $search_query = mysqli_query($con, $search);
            $res = mysqli_fetch_array($search_query);
            ?>
            <h3 class="text-primary">User Profile</h3>
            <p><strong>Full Name:</strong> <?php
            echo $res['name']
                ?></p>
            <p><strong>Email:</strong> <?php
            echo $res['email']
                ?></p>
            <p><strong>Phone Number:</strong> <?php
            echo $res['phone']
                ?></p>
            <p><strong>District:</strong> <?php
            echo $res['district']
                ?></p>
        </div>
    </div>

    <!-- Appointments Table -->
    <div class="container my-5">
        <h4 class="mb-4">Your Appointment History</h4>
        <table id="appointmentsTable" class="display nowrap table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Lawyer Email</th>
                    <th>Appointment Date</th>
                    <th>Your Note</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $get_data = "SELECT * FROM `request_appointment` WHERE `client_email` = '{$_SESSION['user_email']}'";
                $exe_getData = mysqli_query($con, $get_data);
                while ($res = mysqli_fetch_array($exe_getData)) {
                    ?>
                    <tr>
                        <td><?php echo $res['lawyer_email'];?></td>
                        <td><?php echo $res['date'];?></td>
                        <td><?php echo $res['client_note'];?></td>
                        <td><?php echo $res['status'];?></td>
                    </tr>
                    <?php
                }
                ?>

            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        // Initialize DataTables
        $(document).ready(function () {
            $('#appointmentsTable').DataTable({
                responsive: true
            });
        });
    </script>
</body>

</html>