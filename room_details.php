<?php
session_start();

if (!isset($_SESSION['studentID'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['room'])) {
    die("No room selected.");
}

$roomID = $_GET['room'];
include "includes/connection.php";
$studentID = $_SESSION['studentID'];

// Check if student already has a booking
$checkBooking = mysqli_query(
    $connect,
    "SELECT * FROM booking WHERE studentID='$studentID'"
);
$hasBooking = mysqli_num_rows($checkBooking) > 0;

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
INNER JOIN student ON booking.studentID = student.studentID
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
<title>Room Details – D.O.R.M.S.</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
<style>
  .beds-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-top: 24px;
  }
  .bed-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 24px;
    box-shadow: 0 4px 12px var(--shadow);
    text-align: center;
    display: flex;
    flex-direction: column;
    gap: 12px;
    transition: all 0.2s ease;
  }
  .bed-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px var(--shadow);
  }
  .bed-card h3 {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--text-heading);
  }
  .bed-card p {
    font-size: 0.95rem;
    color: var(--text-body);
  }
  .bed-available {
    font-weight: 700;
    color: var(--status-yes-t);
    background: var(--status-yes);
    padding: 4px 12px;
    border-radius: 12px;
    display: inline-block;
    margin: 0 auto;
    font-size: 0.85rem;
  }
</style>
</head>
<body>

<nav class="navbar">
  <div class="logo"><?php echo Icons::home(24); ?> D.O.R.M.S.</div>
  <div class="nav-links">
    <a href="dashboard.php">Dashboard</a>
    <a href="floorplan.php" class="active">Rooms</a>
    <a href="mybooking.php">My Booking</a>
    <a href="support.php">Support</a>
  </div>
  <a href="floorplan.php" class="btn-logout" style="background:#e9ecef; color:var(--text-body);">← Back to Rooms</a>
</nav>

<div class="container">
  <div class="card">
    <h1 style="font-size: 2.2rem; font-weight:800; display:flex; align-items:center; gap:10px;"><?php echo Icons::home(); ?> Room <?php echo htmlspecialchars($room['roomNumber']); ?></h1>
    <h2 style="color:var(--text-muted); font-size:1.1rem; margin-bottom: 24px;">Block <?php echo htmlspecialchars($room['blockName']); ?> • Level <?php echo htmlspecialchars($room['floorLevel']); ?></h2>
    
    <div class="info">
      <div>
        <strong>Block Name</strong>
        <p><?php echo htmlspecialchars($room['blockName']); ?></p>
      </div>
      <div>
        <strong>Floor Level</strong>
        <p>Level <?php echo htmlspecialchars($room['floorLevel']); ?></p>
      </div>
      <div>
        <strong>Capacity</strong>
        <p><?php echo htmlspecialchars($room['currentOccupancy']); ?> / <?php echo htmlspecialchars($room['roomCapacity']); ?> Occupied</p>
      </div>
      <div>
        <strong>Status</strong>
        <p>
          <?php if ($room['roomStatus'] === 'Available'): ?>
            <span class="status-available">Available</span>
          <?php else: ?>
            <span class="status-full">Full</span>
          <?php endif; ?>
        </p>
      </div>
    </div>
  </div>

  <div class="card">
    <h2 style="margin-bottom:12px;">Bed Allocations</h2>
    <p style="color:var(--text-muted); font-size:0.95rem; margin-bottom:24px;">Review room occupancy and book your preferred bed position below.</p>

    <div class="beds-grid">
      <?php for ($i = 1; $i <= intval($room['roomCapacity']); $i++): ?>
        <div class="bed-card">
          <div style="color: var(--bg-nav); margin-bottom: 4px;"><?php echo Icons::bed(40); ?></div>
          <h3>Position Bed <?= $i ?></h3>
          
          <?php if (isset($beds[$i])): ?>
            <p style="color: var(--text-muted);">Occupied by</p>
            <p style="font-weight: 700; color: var(--text-heading); display:flex; align-items:center; justify-content:center; gap:6px;"><?php echo Icons::user(); ?> <?= htmlspecialchars($beds[$i]) ?></p>
          <?php else: ?>
            <span class="bed-available">Available</span>
            <?php if ($room['roomStatus'] === "Available" && !$hasBooking): ?>
              <a href="bookroom.php?roomID=<?= urlencode($roomID) ?>&bed=<?= $i ?>" class="book-btn" style="margin-top: 10px;">Book Bed <?= $i ?></a>
            <?php else: ?>
              <span class="book-btn disabled" style="margin-top: 10px;">Select Bed</span>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</div>

</body>
</html>