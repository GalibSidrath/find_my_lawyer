<?php
session_start();
include 'utils/connection.php';
if (!isset($_SESSION['user_type']) && !isset($_SESSION['user_email'])) {
   ?>
        <script>
            alert('You must log in for apointment as a general user');
            location.replace('index.php');
        </script>
   <?php
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Appointment</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .appointment-box {
            width: 50%;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .appointment-box h4 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="appointment-box">
    <h4>Confirm Appointment</h4>
    <form method = "POST">
        <div class="mb-3">
            <label for="appointmentDate" class="form-label"><strong>Appointment Date:</strong></label>
            <input type="date" name="appointmentDate" class="form-control" id="appointmentDate" required>
        </div>
        <div class="mb-3">
            <label for="clientNote" class="form-label"><strong>Your Note:</strong></label>
            <textarea class="form-control" name="clientNote" id="clientNote" rows="4" placeholder="Write your note here..."></textarea>
        </div>
        <div class="d-grid">
            <button type="submit" name = 'submit' class="btn btn-primary">Request For Appointment</button>
        </div>
    </form>
    
</div>

<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
if (isset($_POST['submit'])) {
    // Use the correct variable names for consistency
    $clientEmail = $_GET['client_email'];

    // Retrieve client information
    $search_client = "SELECT * FROM `general_user` WHERE `email` = '$clientEmail'";
    $search_client_query = mysqli_query($con, $search_client);

    if ($search_client_query && mysqli_num_rows($search_client_query) > 0) {
        $clientInfo = mysqli_fetch_array($search_client_query);
        $clientPhone = $clientInfo['phone'];
        $clientName = $clientInfo['name'];
    } else {
        ?>
        <script>
            alert('Client information not found!');
            location.replace('index.php');
        </script>
        <?php
        exit; // Stop further execution if client info is missing
    }

    // Get lawyer and appointment details
    $lawyerEmail = $_GET['lawyer_mail'];
    $date = $_POST['appointmentDate'];
    $note = $_POST['clientNote'];

    // Insert appointment request
    $request_appointment_query = "
        INSERT INTO `request_appointment` 
        (`lawyer_email`, `client_email`, `client_phone`, `client_name`, `client_note`, `status`, `date`) 
        VALUES ('$lawyerEmail', '$clientEmail', '$clientPhone', '$clientName', '$note', 'pending', '$date')";

    $request_appointment_query_exe = mysqli_query($con, $request_appointment_query);

    if ($request_appointment_query_exe) {
        ?>
        <script>
            alert('Request sent. Please wait for a response. You will be able to see your request status on your profile page.');
            location.replace('index.php');
        </script>
        <?php
    } else {
        ?>
        <script>
            alert('Failed to send request. Please try again.');
        </script>
        <?php
    }
}
?>

