<?php

session_start();
include("connection.php");

$login = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM student
        WHERE (studentID='$login' OR studentEmail='$login')
        AND studentPassword='$password'";

$result = mysqli_query($connect, $sql);

if(mysqli_num_rows($result) > 0){

    $student = mysqli_fetch_assoc($result);

    $studentID = $student['studentID'];

    $eligibility = mysqli_query(
        $connect,
        "SELECT * FROM eligibility
         WHERE studentID='$studentID'
         AND status='YES'"
    );

    if(mysqli_num_rows($eligibility) > 0){

        $_SESSION['studentID'] = $student['studentID'];
        $_SESSION['studentName'] = $student['studentName'];

        header("Location: dashboard.php");
        exit();

    } else {

        echo "
        <script>
        alert('Access Denied. You are not eligible for dorm booking.');
        window.location='index.php';
        </script>
        ";

    }

}else{

    echo "
    <script>
    alert('Invalid Student ID / Email or Password');
    window.location='index.php';
    </script>
    ";

}

?>