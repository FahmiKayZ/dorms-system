<?php

session_start();
include("includes/connection.php");

$login = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['login_role'];

if($role == "student"){

    $sql = "SELECT *
            FROM student
            WHERE (studentID='$login' OR studentEmail='$login')
            AND studentPassword='$password'";

    $result = mysqli_query($connect, $sql);

    if(mysqli_num_rows($result) > 0){

        $student = mysqli_fetch_assoc($result);

        $studentID = $student['studentID'];

        $eligibility = mysqli_query(
            $connect,
            "SELECT *
             FROM eligibility
             WHERE studentID='$studentID'
             AND status='YES'"
        );

        if(mysqli_num_rows($eligibility) > 0){

            $_SESSION['user'] = [
                'role' => 'student',
                'studentID' => $student['studentID'],
                'name' => $student['studentName'],
                'email' => $student['studentEmail']
            ];

            // Compatibility dengan page lama
            $_SESSION['studentID']   = $student['studentID'];
            $_SESSION['studentName'] = $student['studentName'];

            header("Location: dashboard.php");
            exit();

        }else{

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

}else{

    $sql = "SELECT *
            FROM admin
            WHERE adminID='$login'
            AND adminPassword='$password'";

    $result = mysqli_query($connect,$sql);

    if(mysqli_num_rows($result) > 0){

        $admin = mysqli_fetch_assoc($result);

        $_SESSION['user'] = [
            'role' => 'admin',
            'adminID' => $admin['adminID'],
            'name' => $admin['adminName']
        ];

        $_SESSION['adminID'] = $admin['adminID'];
        $_SESSION['adminName'] = $admin['adminName'];

        header("Location: admin_dashboard.php");
        exit();

    }else{

        echo "
        <script>
            alert('Invalid Admin ID or Password');
            window.location='index.php';
        </script>
        ";

    }

}

?>