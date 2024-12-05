<?php
include 'utils/connection.php';
$id = $_GET['id'];
$update_status = "UPDATE `request_appointment` SET `status`='approved' WHERE `id` = $id";
$update_status_exe = mysqli_query($con, $update_status);

$select_data = "SELECT * FROM `request_appointment` WHERE `id` = $id";
$select_data_exe = mysqli_query($con, $select_data);
$res = mysqli_fetch_array($select_data_exe);

$insert_approved_appointment = "INSERT INTO `confirmed_appointment` (`lawyer_email`, `client_email`, `client_name`, `client_phone`, `note`, `date`) 
    VALUES ('" . $res['lawyer_email'] . "', '" . $res['client_email'] . "', '" . $res['client_name'] . "', '" . $res['client_phone'] . "', '" . $res['client_note'] . "', '" . $res['date'] . "')";

    $insert_approved_appointment_exe = mysqli_query($con, $insert_approved_appointment);

    if ($select_data_exe && $insert_approved_appointment_exe) {
        ?>
            <script>
                alert('Appointment Approved!');
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