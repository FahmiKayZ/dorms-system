<?php
session_start();
include("includes/connection.php");

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != "admin") {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {

    $id = mysqli_real_escape_string($connect, $_GET['id']);

    // Delete support tickets
    mysqli_query($connect, "DELETE FROM support_tickets WHERE student_id='$id'");

    // Delete booking
    mysqli_query($connect, "DELETE FROM booking WHERE studentID='$id'");

    // Delete eligibility
    mysqli_query($connect, "DELETE FROM eligibility WHERE studentID='$id'");

    // Delete student
    mysqli_query($connect, "DELETE FROM student WHERE studentID='$id'");

    echo "<script>
        alert('Student deleted successfully.');
        window.location='admin_students.php';
    </script>";
    exit();
}

header("Location: admin_students.php");
exit();
?>