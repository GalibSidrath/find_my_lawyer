<?php
include 'utils/connection.php';

$id = $_GET['id'];
$update_status = "UPDATE `request_appointment` SET `status`='rejected' WHERE `id` = $id";
$update_status_exe = mysqli_query($con, $update_status);
if ($update_status_exe) {
    ?>
        <script>
            alert('Appointment Rejected!');
            location.replace('lawyer_profile.php')
        </script>
    <?php
}else{
    ?>
        <script>
            alert('Something went wrong. Please try again.');
            location.replace('lawyer_profile.php')
        </script>
    <?php
}
?>