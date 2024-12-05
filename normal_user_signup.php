
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Signup</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .signup-box {
            width: 50%;
            margin: auto;
            margin-top: 5%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="signup-box">
        <h2 class="text-center mb-4">User Signup</h2>
        <form method="POST">
            <!-- Full Name -->
            <div class="mb-3">
                <label for="fullName" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="fullName" id="fullName" placeholder="Enter your full name" required>
            </div>
            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
            </div>
            <!-- Phone Number -->
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" name="phoneNumber" id="phoneNumber" placeholder="Enter your phone number" required>
            </div>
            <!-- District -->
            <div class="mb-3">
                <label for="district" class="form-label">District</label>
                <select class="form-select" name="district" id="district" required>
                    <option value="" disabled selected>Select your district</option>
                    <?php 
                        include 'utils/district.php';
                        foreach ($districts as $district) {
                            echo "<option value=\"$district\">$district</option>";
                        }
                    ?>
                </select>
            </div>
            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
            </div>
            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm your password" required>
            </div>
            <!-- Signup Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Signup</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
include "utils/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fullName = mysqli_real_escape_string($con, $_POST['fullName']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phoneNumber']);
    $district = mysqli_real_escape_string($con, $_POST['district']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if email already exists in user_auth or lawyer_user tables
    $checkQuery = "SELECT email FROM user_auth WHERE email = '$email' 
                   UNION 
                   SELECT email FROM general_user WHERE email = '$email'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('An account with this email already exists. Please use a different email.');</script>";
    } else {
        // Check if passwords match
        if ($password !== $confirmPassword) {
            echo "<script>alert('Passwords do not match.');</script>";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert into user_auth table
            $userType = 'general_user'; // Default user type
            $authQuery = "INSERT INTO user_auth (`email`, `password`, `confirm_password`, `user_type`) 
                          VALUES ('$email', '$hashedPassword', '$hashedPassword', '$userType')";
            
            if (mysqli_query($con, $authQuery)) {
                // Get the last inserted ID
                $authId = mysqli_insert_id($con);

                // Insert into general_user table
                $userQuery = "INSERT INTO general_user (name, email, district, phone) 
                              VALUES ('$fullName', '$email', '$district', '$phone')";
                
                if (mysqli_query($con, $userQuery)) {
                    echo "<script>alert('Account created successfully.');</script>";
                    ?>
                    <script>
                        location.replace('index.php');
                    </script>
                <?php
                } else {
                    // Rollback user_auth insertion if general_user fails
                    mysqli_query($con, "DELETE FROM user_auth WHERE id = '$authId'");
                    echo "<script>alert('Error creating account. Please try again.');</script>";
                }
            } else {
                echo "<script>alert('Error creating account. Please try again.');</script>";
            }
        }
    }
}
?>
