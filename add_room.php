<?php
session_start();
include("includes/connection.php");

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != "admin") {
    header("Location: login.php");
    exit();
}

if (isset($_POST['save'])) {
    $roomID = mysqli_real_escape_string($connect, $_POST['roomID']);
    $roomNumber = mysqli_real_escape_string($connect, $_POST['roomNumber']);
    $blockName = mysqli_real_escape_string($connect, $_POST['blockName']);
    $floorLevel = (int)$_POST['floorLevel'];
    $roomCapacity = (int)$_POST['roomCapacity'];

    mysqli_query($connect, "INSERT INTO room(roomID,roomNumber,blockName,floorLevel,roomCapacity,currentOccupancy,roomStatus)
    VALUES('$roomID','$roomNumber','$blockName','$floorLevel','$roomCapacity',0,'Available')");

    header("Location: admin_rooms.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Room – D.O.R.M.S.</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/admin.css">
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <a href="admin_dashboard.php" class="sidebar-header"><?php echo Icons::dashboard(24); ?> D.O.R.M.S.<span>.</span></a>
  <ul class="sidebar-menu">
    <li><a href="admin_dashboard.php"><?php echo Icons::dashboard(); ?> Dashboard</a></li>
    <li><a href="admin_students.php"><?php echo Icons::users(); ?> Manage Students</a></li>
    <li class="active"><a href="admin_rooms.php"><?php echo Icons::home(); ?> Manage Rooms</a></li>
    <li><a href="admin_eligibility.php"><?php echo Icons::check(); ?> Eligibility Approvals</a></li>
    <li><a href="admin_support.php"><?php echo Icons::ticket(); ?> Support Tickets</a></li>
  </ul>
  <div class="sidebar-footer">
    <a href="index.php?logout=1" class="action-btn btn-delete" style="width:100%; justify-content:center; padding: 10px; display:flex; align-items:center; gap:8px;" onclick="return confirm('Are you sure you want to log out of D.O.R.M.S. Admin?')"><?php echo Icons::logout(); ?> Log Out</a>
  </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
  <div class="page-header">
    <div>
      <h1 style="display:flex; align-items:center; gap:10px;"><?php echo Icons::plus(28); ?> Add New Room</h1>
      <p style="color:var(--text-muted); font-size:0.95rem;">Register a new dormitory room and configure its capacity details.</p>
    </div>
    <a href="admin_rooms.php" class="add-btn" style="background:#e9ecef; color:var(--text-heading); border:1px solid var(--border);">← Back to Rooms</a>
  </div>

  <div class="panel" style="max-width: 600px;">
    <form method="POST">
      <div class="form-group">
        <label for="roomID">Room ID / Key</label>
        <input type="text" id="roomID" name="roomID" placeholder="e.g. K-101" required>
      </div>

      <div class="form-group">
        <label for="roomNumber">Room Display Number</label>
        <input type="text" id="roomNumber" name="roomNumber" placeholder="e.g. A-101" required>
      </div>

      <div class="form-group">
        <label for="blockName">Block Name</label>
        <select id="blockName" name="blockName" required>
          <option value="">Select Block</option>
          <option value="Kasa">Kasa (Male Block)</option>
          <option value="Sutera">Sutera (Female Block)</option>
        </select>
      </div>

      <div class="form-group">
        <label for="floorLevel">Floor Level</label>
        <input type="number" id="floorLevel" name="floorLevel" min="1" max="10" placeholder="e.g. 1" required>
      </div>

      <div class="form-group">
        <label for="roomCapacity">Room Bed Capacity</label>
        <input type="number" id="roomCapacity" name="roomCapacity" min="1" max="8" value="2" required>
      </div>

      <button type="submit" name="save" class="btn-save" style="width:100%; padding:14px; margin-top:10px; display:flex; align-items:center; justify-content:center; gap:8px;"><?php echo Icons::plus(); ?> Register Room</button>
    </form>
  </div>
</div>

</body>
</html>