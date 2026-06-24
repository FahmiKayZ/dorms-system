<?php
session_start();

if(!isset($_SESSION['studentID'])){
    header("Location: login.php");
    exit();
}

$roomID = $_GET['roomID'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Room</title>
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

    <a href="floorplan.php" class="logout-btn">Back</a>
</nav>

<div class="dashboard-container">

    <div class="welcome-box">

        <h1>Confirm Booking</h1>

        <div class="booking-details">

            <h2>Selected Room</h2>

            <p>
                <strong>Room ID :</strong>
                <?php echo $roomID; ?>
            </p>

            <p>
                Please confirm your booking before proceeding.
            </p>

            <form action="savebooking.php" method="POST">

                <input type="hidden"
                       name="roomID"
                       value="<?php echo $roomID; ?>">

                <button type="submit" class="dashboard-btn">
                    Confirm Booking
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>