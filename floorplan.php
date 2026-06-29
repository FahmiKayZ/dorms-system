<?php

session_start();

if(!isset($_SESSION['studentID'])){
    header("Location: login.php");
    exit();
}

include("connection.php");

$studentID = $_SESSION['studentID'];

$checkBooking = mysqli_query(
    $connect,
    "SELECT *
     FROM booking
     WHERE studentID='$studentID'"
);

$hasBooking = mysqli_num_rows($checkBooking) > 0;

$getStudent = mysqli_query(
    $connect,
    "SELECT studentGender
     FROM student
     WHERE studentID='$studentID'"
);

$studentData = mysqli_fetch_assoc($getStudent);

$gender = $studentData['studentGender'];

if($gender == "Male"){

    $sql = "
    SELECT *
    FROM room
    WHERE blockName='Kasa'
    ORDER BY floorLevel, roomNumber
    ";

}else{

    $sql = "
    SELECT *
    FROM room
    WHERE blockName='Sutera'
    ORDER BY floorLevel, roomNumber
    ";

}

$result = mysqli_query($connect,$sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Room Floor Plan</title>

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

    <a href="dashboard.php" class="logout-btn">
        Back
    </a>

</nav>

<div class="container">

    <div class="page-title">
        <h1>Available Rooms</h1>
        <p>View and book available dormitory rooms.</p>
    </div>

    <div class="room-grid">

        <?php while($row=mysqli_fetch_assoc($result)){ ?>

        <div class="room-card <?php echo strtolower($row['roomStatus']); ?>">

            <h2><?php echo $row['roomNumber']; ?></h2>

            <p><strong>Block:</strong> <?php echo $row['blockName']; ?></p>

            <p><strong>Floor:</strong> <?php echo $row['floorLevel']; ?></p>

            <p>
                <strong>Occupancy:</strong>
                <?php echo $row['currentOccupancy']; ?>
                /
                <?php echo $row['roomCapacity']; ?>
            </p>

            <p class="status <?php echo strtolower($row['roomStatus'])=='available'
            ? 'status-available'
            : 'status-full'; ?>">

            <?php if($row['roomStatus']=="Available" && !$hasBooking){ ?>

                <a href="room_details.php?room=<?php echo $row['roomID']; ?>"
                class="book-btn">
                View Room
                </a>

            <?php } ?>

        </div>

        <?php } ?>

    </div>

</div>

</body>
</html>