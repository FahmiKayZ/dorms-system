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

?>

<!DOCTYPE html>
<html>
<head>
    <title>Cancel Booking</title>
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

    <a href="dashboard.php" class="logout-btn">
        ← Back to Dashboard
    </a>

</nav>

<div class="dashboard-container">

    <div class="welcome-box">

        <h1>Cancel Booking</h1>

        <?php

        $hasBooking = mysqli_num_rows($result) > 0;

        if($hasBooking){

        while($row=mysqli_fetch_assoc($result)){ ?>

        <div class="booking-info">

            <p>
                <strong>🏠 Room ID :</strong>
                <?php echo $row['roomID']; ?>
            </p>

            <p>
                <strong>🟢 Status :</strong>
                <?php echo $row['bookingStatus']; ?>
            </p>

            <form action="deletebooking.php"
                  method="POST"

                  onsubmit="return confirm('Are you sure you want to cancel this booking?');">

                <input
                    type="hidden"
                    name="bookingID"
                    value="<?php echo $row['bookingID']; ?>">

                <button
                    type="submit"
                    class="cancel-btn">

                    🗑 Cancel Booking

                </button>

            </form>

        </div>

        <?php }

        } else { ?>

        <p>🛏️ You don't have any active booking to cancel.</p>
        <br>
        <a href="floorplan.php" class="book-btn">View Available Rooms</a>

        <?php } ?>

    </div>

</div>

</body>
</html>