<?php

include("connection.php");

$result = "";

if(isset($_POST['check'])){

    $studentID = mysqli_real_escape_string(
        $connect,
        $_POST['studentID']
    );

    $sql = mysqli_query(
        $connect,
        "SELECT *
         FROM eligibility
         WHERE studentID='$studentID'"
    );

    if(mysqli_num_rows($sql)>0){

        $row = mysqli_fetch_assoc($sql);

        if($row['status']=="YES"){

    $result='
    <div class="eligible success">
        <h2>✅ Eligible</h2>
        <p>
        <p>Congratulations! You are eligible to apply for accommodation at Kolej Kerawang. You may now proceed with your room booking application.
        </p>
    </div>';

}
elseif($row['status']=="Pending"){

    $result='
    <div class="eligible pending">
        <h2>🟡 Pending</h2>
        <p>Your eligibility application for Kolej Kerawang is currently under review. Please wait for approval from the College Administration Office.
        </p>
       
    </div>';

}
elseif($row['status']=="NO"){

    $result='
    <div class="eligible fail">
        <h2>❌ Not Eligible</h2>
        <p>Sorry, you are currently not eligible to apply for accommodation at Kolej Kerawang. Please contact the College Administration Office for further assistance.
        </p>
    </div>';

}
    }else{
        $result='
        <div class="eligible fail">
            <h2>Student Not Found</h2>
            <p>Please enter a valid Student ID.</p>
        </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Check Eligibility</title>

<link rel="stylesheet" href="css/homepage.css">

</head>

<body>

<nav class="navbar">
    <a href="index.php" class="nav-brand">
        <div class="nav-brand-icon">🏠</div>
        <span class="nav-brand-text">
            D.O.R.M.S.
        </span>
    </a>
    <ul class="nav-links">
        <li>
            <a href="index.php">
                Home
            </a>
        </li>
        <li>
            <a class="active" href="eligibility.php">
                Check Eligibility
            </a>
        </li>
    </ul>
    <div class="nav-actions">
        <a href="register.php" class="btn-primary">
            Register
        </a>
    </div>
</nav>


<section class="support-page">

<div class="support-header">

<h1>Check Eligibility</h1>

<p>
Enter your Student ID to verify whether you are eligible
to apply for university accommodation.
</p>

</div>


<div class="ticket-card">

<form method="POST">

<input
type="text"
name="studentID"
placeholder="Enter Student ID"
required>

<button type="submit" name="check">

Check Eligibility

</button>

<?= $result ?>

</form>

</div>

</section>

</body>

</html>