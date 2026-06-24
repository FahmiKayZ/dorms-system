<?php

session_start();
include("connection.php");

$studentID = $_SESSION['studentID'];

$sql = "
SELECT *
FROM booking
WHERE studentID='$studentID'
";

$result = mysqli_query($connect,$sql);

$booking = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Booking</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<nav class="navbar">
    <div class="logo">D.O.R.M.S.</div>

    <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="floorplan.php">Rooms</a>
        <a href="mybooking.php">My Booking</a>
    </div>

    <a href="dashboard.php" class="logout-btn">Back</a>
</nav>

<div class="dashboard-container">

    <div class="welcome-box">

        <h1>My Current Booking</h1>

        <?php if($booking){ ?>

            <div class="booking-info">

                <p>
                    <strong>Room ID :</strong>
                    <?php echo $booking['roomID']; ?>
                </p>

                <p>
                    <strong>Status :</strong>
                    <?php echo $booking['bookingStatus']; ?>
                </p>

                <p>
                    <strong>Booking Date :</strong>
                    <?php echo $booking['bookingDate']; ?>
                </p>

            </div>

        <?php } else { ?>

            <p>No booking found.</p>

        <?php } ?>

    </div>

</div>

</body>
</html>