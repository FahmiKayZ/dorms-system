<?php

if (!isset($_GET['room'])) {
    die("No room selected.");
}

$roomID = $_GET['room'];
include "includes/connection.php";
$occupants = mysqli_query($connect, "
SELECT
booking.bedNumber,
student.studentName
FROM booking
INNER JOIN student
ON booking.studentID = student.studentID
WHERE booking.roomID = '$roomID'
ORDER BY booking.bedNumber ASC
");
$stmt = $connect->prepare("SELECT * FROM room WHERE roomID = ?");
$stmt->bind_param("s", $roomID);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Room not found.");
}

$room = $result->fetch_assoc();
$occupantSQL = "
SELECT
    booking.bedNumber,
    student.studentName
FROM booking
INNER JOIN student
ON booking.studentID = student.studentID
WHERE booking.roomID = ?
ORDER BY booking.bedNumber
";

$stmt2 = $connect->prepare($occupantSQL);
$stmt2->bind_param("s", $roomID);
$stmt2->execute();

$occupants = $stmt2->get_result();
$beds = [];

while ($row = $occupants->fetch_assoc()) {
    $beds[$row['bedNumber']] = $row['studentName'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Details</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<div class="dashboard-container">
<div class="room-header">

    <h1>🏠 Room <?= htmlspecialchars($roomID) ?></h1>

    <div class="room-info">

        <p>
            📍 <strong>Block :</strong>
            <?= $room['blockName']; ?>
        </p>

        <p>
            🏢 <strong>Floor :</strong>
            <?= $room['floorLevel']; ?>
        </p>

        <p>
            👥 <strong>Occupancy :</strong>
            <?= $room['currentOccupancy']; ?>
            /
            <?= $room['roomCapacity']; ?>
        </p>

        <p>
            📊 <strong>Status :</strong>
            <?= $room['roomStatus']; ?>
        </p>

    </div>

</div>

<h2>Current Occupants</h2>

<div class="beds-grid">
<?php for($i = 1; $i <= $room['roomCapacity']; $i++) { ?>

<div class="bed-card">

    <h3>🛏 Bed <?= $i ?></h3>

    <?php if(isset($beds[$i])) { ?>

        <p>👤 <?= htmlspecialchars($beds[$i]) ?></p>

    <?php } else { ?>

        <p class="bed-available">🟢 Available</p>

        <?php if($room['roomStatus']=="Available") { ?>

            <a href="bookroom.php?roomID=<?= $roomID ?>&bed=<?= $i ?>" class="book-btn">
                Book This Bed
            </a>

        <?php } ?>

    <?php } ?>

</div>

<?php } ?>
</div>
</div>
</body>
</html>