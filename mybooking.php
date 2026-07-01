<?php

session_start();
include("includes/connection.php");

$studentID = $_SESSION['studentID'];

$sql = "
SELECT
booking.*,
room.blockName,
room.floorLevel
FROM booking
INNER JOIN room
ON booking.roomID = room.roomID
WHERE booking.studentID='$studentID'
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

    <a href="dashboard.php" class="logout-btn">← Back to Dashboard</a>
</nav>

<div class="dashboard-container">

    <div class="welcome-box">

        <h1>My Current Booking</h1>

        <?php if($booking){ ?>

            <div class="booking-info">

    <h2>🏠 Room <?php echo $booking['roomID']; ?></h2>

    <p>
        <strong>🛏 Bed :</strong>
        Bed <?php echo $booking['bedNumber']; ?>
    </p>

    <p>
        <strong>📍 Block :</strong>
        <?php echo $booking['blockName']; ?>
    </p>

    <p>
        <strong>🏢 Floor :</strong>
        <?php echo $booking['floorLevel']; ?>
    </p>

    <p>
        <strong>🟢 Status :</strong>
        <?php echo $booking['bookingStatus']; ?>
    </p>

    <p>
        <strong>📅 Booking Date :</strong>
        <?php echo date("d M Y, h:i A", strtotime($booking['bookingDate'])); ?>
    </p>

    <br>

    <form action="cancelbooking.php" method="POST">

        <input
            type="hidden"
            name="bookingID"
            value="<?php echo $booking['bookingID']; ?>">

        <button
            type="submit"
            class="cancel-btn">
            Cancel Booking
        </button>

    </form>

</div>
        <?php } else { ?>
            <p>No booking found.</p>
            <br>
            <a href="floorplan.php" class="book-btn">View Available Rooms</a>
        <?php } ?>
    </div>
</div>
</body>
</html>