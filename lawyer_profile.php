<?php
session_start();
include 'utils/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lawyer Profile</title>
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

        .tabs-section {
            margin-top: 2rem;
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
                        <a class="nav-link active" href="lawyer_profile.php">Profile</a>
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

    <!-- Lawyer Details Section -->
    <div class="container my-5">
        <div class="profile-section">
            <?php
            $search = "SELECT * FROM `lawyer_user` WHERE `email` = '{$_SESSION['user_email']}'";
            $search_query = mysqli_query($con, $search);
            $res = mysqli_fetch_array($search_query);
            ?>
            <h3 class="text-primary">Lawyer Profile</h3>
            <p><strong>Full Name:</strong> <?php echo $res['name'] ?></p>
            <p><strong>Email:</strong> <?php echo $res['email'] ?></p>
            <p><strong>Phone Number:</strong> <?php echo $res['phone'] ?></p>
            <p><strong>Field of Expertise:</strong> <?php echo $res['expertise'] ?> Lawyer</p>
            <p><strong>Years of Experience:</strong> <?php echo $res['experience'] ?> Years</p>
            <p><strong>Chamber Address:</strong> <?php echo $res['address'] ?></p>
        </div>
    </div>

    <!-- Tabs Section -->
    <div class="container tabs-section">
        <ul class="nav nav-tabs" id="profileTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="requests-tab" data-bs-toggle="tab" data-bs-target="#requests"
                    type="button" role="tab">Appointment Requests</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="today-tab" data-bs-toggle="tab" data-bs-target="#today" type="button"
                    role="tab">Today's Appointments</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button"
                    role="tab">All Appointments</button>
            </li>
        </ul>

        <div class="tab-content" id="profileTabsContent">
            <!-- Appointment Requests Tab -->
            <div class="tab-pane fade show active" id="requests" role="tabpanel">
                <div class="mt-4">
                    <table id="requestsTable" class="display nowrap table table-striped table-bordered"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>Client Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Appointment Date</th>
                                <th>Client Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $search_rq = "SELECT * FROM `request_appointment` WHERE `lawyer_email` = '{$_SESSION['user_email']}' AND `status` = 'pending' ORDER BY `date` DESC";
                            $search_rq_exe = mysqli_query($con, $search_rq);
                            while ($res = mysqli_fetch_array($search_rq_exe)) {
                                ?>
                                <tr>
                                    <td><?php echo $res['client_name'] ?></td>
                                    <td><?php echo $res['client_email'] ?></td>
                                    <td><?php echo $res['client_phone'] ?></td>
                                    <td><?php echo $res['date'] ?></td>
                                    <td><?php echo $res['client_note'] ?></td>
                                    <td>
                                        <a href="approve_appointment.php?id=<?php echo $res['id'] ?>" class="btn btn-success btn-sm">Approve</a>
                                        <a href="reject_appointment.php?id=<?php echo $res['id'] ?>" class="btn btn-danger btn-sm">Reject</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Today's Appointments Tab -->
            <div class="tab-pane fade" id="today" role="tabpanel">
                <div class="mt-4">
                    <table id="todayTable" class="display nowrap table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Client Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Appointment Date</th>
                                <th>Client Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Get today's date in the format used in your database (e.g., YYYY-MM-DD)
                            $today = date('Y-m-d');

                            // Update the query to include today's date condition
                            $search_today = "SELECT * FROM `confirmed_appointment` 
                  WHERE `lawyer_email` = '{$_SESSION['user_email']}'  
                  AND `date` = '$today' ORDER BY `date` DESC";

                            $search_today_exe = mysqli_query($con, $search_today);

                            while ($res = mysqli_fetch_array($search_today_exe)) {
                                ?>
                                <tr>
                                    <td><?php echo $res['client_name'] ?></td>
                                    <td><?php echo $res['client_email'] ?></td>
                                    <td><?php echo $res['client_phone'] ?></td>
                                    <td><?php echo $res['date'] ?></td>
                                    <td><?php echo $res['note'] ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>

            <!-- All Appointments Tab -->
            <div class="tab-pane fade" id="all" role="tabpanel">
                <div class="mt-4">
                    <table id="allTable" class="display nowrap table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Client Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Appointment Date</th>
                                <th>Client Note</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $search_rq = "SELECT * FROM `request_appointment` WHERE `lawyer_email` = '{$_SESSION['user_email']}' ORDER BY `date` DESC";
                            $search_rq_exe = mysqli_query($con, $search_rq);
                            while ($res = mysqli_fetch_array($search_rq_exe)) {
                                ?>
                                <tr>
                                    <td><?php echo $res['client_name'] ?></td>
                                    <td><?php echo $res['client_email'] ?></td>
                                    <td><?php echo $res['client_phone'] ?></td>
                                    <td><?php echo $res['date'] ?></td>
                                    <td><?php echo $res['client_note'] ?></td>
                                    <td><?php echo $res['status'] ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        // Initialize DataTables for all tabs
        $(document).ready(function () {
            $('#requestsTable').DataTable({ responsive: true });
            $('#todayTable').DataTable({ responsive: true });
            $('#allTable').DataTable({ responsive: true });
        });
    </script>
</body>

</html>