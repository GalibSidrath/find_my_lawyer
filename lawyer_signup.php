<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lawyer Signup</title>
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
        <h2 class="text-center mb-4">Lawyer Signup</h2>
        <form method="POST">
            <!-- Form Fields -->
            <!-- Full Name -->
            <div class="mb-3">
                <label for="fullName" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="fullName" id="fullName" required>
            </div>
            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <!-- Phone -->
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" name="phoneNumber" id="phoneNumber" required>
            </div>
            <!-- Educational Qualifications -->
            <div class="mb-3">
                <label for="qualifications" class="form-label">Educational Qualifications</label>
                <textarea class="form-control" name="qualifications" id="qualifications" rows="2" required></textarea>
            </div>
            <!-- District -->
            <div class="mb-3">
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
            <!-- Expertise -->
            <div class="mb-3">
                <label for="expertise" class="form-label">Expertise</label>
                <select class="form-select" name="expertise" id="expertise" required>
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
                <!-- Add more options as needed -->
                </select>
            </div>
            <!-- Experience -->
            <div class="mb-3">
                <label for="experience" class="form-label">Years of Experience</label>
                <input type="number" class="form-control" name="experience" id="experience" min="0" required>
            </div>
            <!-- Chamber Address -->
            <div class="mb-3">
                <label for="chamberAddress" class="form-label">Chamber Address</label>
                <textarea class="form-control" name="chamberAddress" id="chamberAddress" rows="2" required></textarea>
            </div>
            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" required>
            </div>
            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Signup</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
include "utils/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form inputs
    $fullName = mysqli_real_escape_string($con, $_POST['fullName']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phoneNumber']);
    $education = mysqli_real_escape_string($con, $_POST['qualifications']);
    $district = mysqli_real_escape_string($con, $_POST['district']);
    $expertise = mysqli_real_escape_string($con, $_POST['expertise']);
    $experience = mysqli_real_escape_string($con, $_POST['experience']);
    $address = mysqli_real_escape_string($con, $_POST['chamberAddress']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if email already exists
    $checkQuery = "SELECT email FROM user_auth WHERE email = '$email' 
                   UNION 
                   SELECT email FROM lawyer_user WHERE email = '$email'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('An account with this email already exists. Please use a different email.');</script>";
    } else {
        // Validate password match
        if ($password !== $confirmPassword) {
            echo "<script>alert('Passwords do not match.');</script>";
        } else {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $userType = 'lawyer_user';

            // Insert into user_auth
            $authQuery = "INSERT INTO user_auth (email, password, confirm_password, user_type) VALUES ('$email', '$hashedPassword', '$hashedPassword', '$userType')";

            if (mysqli_query($con, $authQuery)) {
                $authId = mysqli_insert_id($con);

                // Insert into lawyer_user
                $lawyerQuery = "INSERT INTO lawyer_user (id, name, email, phone, education, district, expertise, experience, address)
                                VALUES ('$authId', '$fullName', '$email', '$phone', '$education', '$district', '$expertise', '$experience', '$address')";

                if (mysqli_query($con, $lawyerQuery)) {
                    echo "<script>alert('Account created successfully.');</script>";
                    ?>
                        <script>
                            location.replace('index.php');
                        </script>
                    <?php
                } else {
                    mysqli_query($con, "DELETE FROM user_auth WHERE id = '$authId'");
                    echo "<script>alert('Error creating account.');</script>";
                }
            } else {
                echo "<script>alert('Error creating account.');</script>";
            }
        }
    }
}
?>
