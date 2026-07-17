<?php
session_start();

if (!isset($_SESSION['studentID'])) {
    header("Location: login.php");
    exit();
}

include("includes/connection.php");

$studentID = $_SESSION['studentID'];

$checkBooking = mysqli_query(
    $connect,
    "SELECT * FROM booking WHERE studentID='$studentID'"
);
$hasBooking = mysqli_num_rows($checkBooking) > 0;

$getStudent = mysqli_query(
    $connect,
    "SELECT studentGender FROM student WHERE studentID='$studentID'"
);
$studentData = mysqli_fetch_assoc($getStudent);
$gender = $studentData['studentGender'] ?? 'Male';

if ($gender == "Male") {
    $block = "Kasa (Male Block)";
    $sql = "SELECT * FROM room WHERE blockName='Kasa' ORDER BY floorLevel, roomNumber";
} else {
    $block = "Sutera (Female Block)";
    $sql = "SELECT * FROM room WHERE blockName='Sutera' ORDER BY floorLevel, roomNumber";
}

$result = mysqli_query($connect, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rooms – D.O.R.M.S.</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
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
  <a href="dashboard.php" class="btn-logout" style="background:#e9ecef; color:var(--text-body);">← Back to Dashboard</a>
</nav>

<div class="container">
  <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--border); padding-bottom:16px;">
    <div>
      <h1 style="font-size:2rem; font-weight:800; color:var(--text-heading);">Available Rooms</h1>
      <p style="color:var(--text-muted); font-size:0.95rem;">Select an available room in your assigned block to secure a bed.</p>
    </div>
    <span class="status-available" style="padding: 8px 16px; font-size: 0.9rem; display:flex; align-items:center; gap:6px;"><?php echo Icons::pin(); ?> Block: <?php echo htmlspecialchars($block); ?></span>
  </div>

  <?php if ($hasBooking): ?>
    <div class="status-full" style="display:flex; align-items:center; gap:10px; padding:16px; border-radius:var(--radius); font-size:0.95rem; font-weight:600; margin-bottom:10px; width:100%;">
      <span><?php echo Icons::warning(); ?> You already have an active room booking or reservation. You cannot book another room.</span>
    </div>
  <?php endif; ?>

  <div class="room-grid">
    <?php while ($row = mysqli_fetch_assoc($result)): 
      $current = intval($row['currentOccupancy']);
      $capacity = intval($row['roomCapacity']);
      $pct = ($capacity > 0) ? ($current / $capacity) * 100 : 0;
      $isAvailable = ($row['roomStatus'] === 'Available' && $current < $capacity);
    ?>
      <div class="room-card">
        <div class="room-header">
          <span class="room-title">Room <?php echo htmlspecialchars($row['roomNumber']); ?></span>
          <span class="<?php echo $isAvailable ? 'status-available' : 'status-full'; ?>">
            <?php echo $isAvailable ? 'Available' : 'Full'; ?>
          </span>
        </div>

        <div class="room-details-list">
          <div>Floor: <strong>Level <?php echo htmlspecialchars($row['floorLevel']); ?></strong></div>
          <div style="display:flex; justify-content:space-between; align-items:center; margin-top:8px;">
            <span>Occupancy:</span>
            <strong><?php echo $current; ?> / <?php echo $capacity; ?> beds</strong>
          </div>
          <div class="room-progress">
            <div class="room-progress-bar" style="width: <?php echo $pct; ?>%; <?php echo ($current >= $capacity) ? 'background:#dc3545;' : ''; ?>"></div>
          </div>
        </div>

        <?php if ($isAvailable && !$hasBooking): ?>
          <a href="room_details.php?room=<?php echo $row['roomID']; ?>" class="book-btn">View Details & Book</a>
        <?php else: ?>
          <span class="book-btn disabled">Not Available</span>
        <?php endif; ?>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>