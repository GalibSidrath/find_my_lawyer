<?php

include 'utils/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];
    $userType = $_POST['userType'];

    // Query to fetch user data from `user_auth` table
    $query = "SELECT * FROM `user_auth` WHERE email='$email' AND user_type='$userType'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_type'] = $user['user_type'];

            // Redirect back to the same page
            ?>
            <script>
                location.replace('index.php');
            </script>
            <?php
            exit;
        } else {
            ?>
            <script>
                alert('Invalid email or password 1');
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            alert('Invalid email or password 2');
        </script>
        <?php
    }
}

?>