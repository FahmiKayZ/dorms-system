<?php
session_start();

if (!isset($_SESSION['studentID'])) {
    header("Location: login.php");
    exit();
}

include("includes/connection.php");

$name = $_SESSION['studentName'];
$id = $_SESSION['studentID'];

$eligibilitySQL = mysqli_query(
    $connect,
    "SELECT status FROM eligibility WHERE studentID='$id'"
);
$eligibilityData = mysqli_fetch_assoc($eligibilitySQL);

$sql = "SELECT * FROM booking WHERE studentID='$id' LIMIT 1";
$result = mysqli_query($connect, $sql);
$booking = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - D.O.R.M.S.</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
  <div class="logo"><?php echo Icons::home(24); ?> D.O.R.M.S.</div>
  <div class="nav-links">
    <a href="dashboard.php" class="active">Dashboard</a>
    <a href="floorplan.php">Rooms</a>
    <a href="mybooking.php">My Booking</a>
    <a href="support.php">Support</a>
  </div>
  <a href="logout.php" class="btn-logout" onclick="return confirm('Are you sure you want to log out of D.O.R.M.S?')">Logout</a>
</nav>

<div class="container">
  <!-- Welcome & Profile Card -->
  <div class="card">
    <h1>Welcome Back <?php echo Icons::wave(28); ?></h1>
    <h2><?php echo htmlspecialchars($name); ?></h2>
    
    <div class="info">
      <div>
        <strong>Student ID</strong>
        <p><?php echo htmlspecialchars($id); ?></p>
      </div>
      <div>
        <strong>Eligibility Status</strong>
        <p>
        <?php
        $elig = $eligibilityData['status'] ?? 'Pending';
        if ($elig === "YES") {
            echo "<span class='status-available'>" . Icons::check() . " Eligible</span>";
        } elseif ($elig === "NO") {
            echo "<span class='status-full'>" . Icons::cross() . " Not Eligible</span>";
        } else {
            echo "<span class='status-full' style='background:#ffeeba; color:#856404;'>" . Icons::clock() . " Pending</span>";
        }
        ?>
        </p>
      </div>
    </div>
  </div>

  <!-- Quick Actions Grid -->
  <div class="action-section">
    <a href="floorplan.php" class="action-card">
      <span class="icon" style="color:var(--bg-nav);"><?php echo Icons::bed(40); ?></span>
      <h3>Book a Room</h3>
      <p>Browse available blocks, floors, and secure your bed space.</p>
    </a>
    <a href="mybooking.php" class="action-card">
      <span class="icon" style="color:var(--bg-nav);"><?php echo Icons::ticket(40); ?></span>
      <h3>My Booking</h3>
      <p>Check the details and status of your active accommodation.</p>
    </a>
    <a href="support.php" class="action-card">
      <span class="icon" style="color:var(--bg-nav);"><?php echo Icons::mail(40); ?></span>
      <h3>Support Tickets</h3>
      <p>Submit dynamic tickets or query existing help requests.</p>
    </a>
  </div>

  <!-- Current Booking Overview Card -->
  <div class="card">
    <h2>Current Booking Status</h2>
    <?php if ($booking): ?>
      <div class="booking-summary-card">
        <div class="booking-meta">
          <div>
            <span>Room ID</span>
            <strong><?php echo htmlspecialchars($booking['roomID']); ?></strong>
          </div>
          <div>
            <span>Bed Position</span>
            <strong>Bed <?php echo htmlspecialchars($booking['bedID'] ?? '1'); ?></strong>
          </div>
          <div>
            <span>Status</span>
            <strong>
              <?php
              $status = $booking['bookingStatus'];
              if ($status === 'Approved') {
                  echo "<span class='status-available'>Approved</span>";
              } elseif ($status === 'Pending') {
                  echo "<span class='status-full' style='background:#fff3cd; color:#856404;'>Pending Approval</span>";
              } else {
                  echo "<span class='status-full'>Cancelled</span>";
              }
              ?>
            </strong>
          </div>
          <div>
            <span>Booking Date</span>
            <strong><?php echo htmlspecialchars($booking['bookingDate']); ?></strong>
          </div>
        </div>
        
        <div style="margin-top: 10px;">
          <a href="cancelbooking.php" class="btn-logout" style="display:inline-block; padding: 12px 24px; text-align:center;">Cancel Booking Reservation</a>
        </div>
      </div>
    <?php else: ?>
      <div style="text-align: center; padding: 20px; color: var(--text-muted);">
        <p style="margin-bottom: 12px; color:var(--bg-nav);"><?php echo Icons::bed(48); ?></p>
        <p style="font-weight: 600; font-size: 1.1rem; margin-bottom: 8px;">No active room booking found.</p>
        <p style="font-size: 0.9rem; margin-bottom: 20px;">You are currently eligible to book a room. Secure your spot now!</p>
        <a href="floorplan.php" class="btn-submit" style="text-decoration:none; display:inline-block;">Browse Rooms</a>
      </div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>