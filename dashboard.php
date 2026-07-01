<?php

session_start();

if(!isset($_SESSION['studentID'])){
    header("Location: login.php");
    exit();
}

include("includes/connection.php");

$name = $_SESSION['studentName'];
$id = $_SESSION['studentID'];

$eligibilitySQL = mysqli_query(
    $connect,
    "SELECT status
     FROM eligibility
     WHERE studentID='$id'"
);

$eligibilityData = mysqli_fetch_assoc($eligibilitySQL);

$sql = "
SELECT *
FROM booking
WHERE studentID='$id'
LIMIT 1
";

$result = mysqli_query($connect,$sql);
$booking = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>D.O.R.M.S Dashboard</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<nav class="navbar">

    <div class="logo">
        D.O.R.M.S.
    </div>

    <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="floorplan.php">Rooms</a>
        <a href="mybooking.php">My Booking</a>
    </div>

    <a href="logout.php"
   class="btn-logout"
   onclick="return confirm('Are you sure you want to log out of D.O.R.M.S?')">
   Logout
</a>

</nav>

<div class="container">

    <div class="card">

        <h1>Welcome Back 👋</h1>

        <h2><?php echo $name; ?></h2>

        <div class="info">

            <div>
                <strong>Student ID</strong>
                <p><?php echo $id; ?></p>
            </div>

            <div>
                <strong>Eligibility</strong>
                <p>
                <?php
                $elig = $eligibilityData['status'] ?? null;
                if($elig=="YES"){
                    echo "<span class='status-available'>✅ Eligible</span>";
                } elseif($elig=="NO"){
                    echo "<span class='status-full'>❌ Not Eligible</span>";
                } else {
                    echo "<span class='status-full'>No Data</span>";
                }
                ?>
                </p>
            </div>

        </div>

    </div>

    <div class="actions">

        <a href="floorplan.php" class="action-btn">
            View Rooms
        </a>

        <a href="mybooking.php" class="action-btn">
            My Booking
        </a>

        <?php if($booking){ ?>
        <a href="cancelbooking.php" class="action-btn">
            Cancel Booking
        </a>
        <?php } ?>

    </div>

    <br>

    <div class="card">

        <h2>Current Booking</h2>

        <?php if($booking){ ?>

        <div class="booking-details">

            <p><strong>Room:</strong> <?php echo $booking['roomID']; ?></p>

            <p><strong>Status:</strong> <?php echo $booking['bookingStatus']; ?></p>

            <p><strong>Date:</strong> <?php echo $booking['bookingDate']; ?></p>

        </div>

        <?php } else { ?>

            <p>🛏️ No active booking found.</p>

        <?php } ?>

    </div>

</div>

</body>
</html>