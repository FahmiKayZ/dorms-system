<?php
session_start();
include("includes/connection.php");

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != "admin") {
    header("Location: login.php");
    exit();
}

$adminName = $_SESSION['user']['name'];

$totalStudents = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM student"));
$totalRooms = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM room"));
$pendingEligibility = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM eligibility WHERE status='Pending'"));
$totalSupport = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM support_tickets WHERE status='Pending'"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard – D.O.R.M.S.</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/admin.css">
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <a href="admin_dashboard.php" class="sidebar-header"><?php echo Icons::dashboard(24); ?> D.O.R.M.S.<span>.</span></a>
  <ul class="sidebar-menu">
    <li class="active"><a href="admin_dashboard.php"><?php echo Icons::dashboard(); ?> Dashboard</a></li>
    <li><a href="admin_students.php"><?php echo Icons::users(); ?> Manage Students</a></li>
    <li><a href="admin_rooms.php"><?php echo Icons::home(); ?> Manage Rooms</a></li>
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
      <h1>Admin Dashboard</h1>
      <p style="color:var(--text-muted); font-size:0.95rem;">Welcome back, <strong><?php echo htmlspecialchars($adminName); ?></strong>. Here is the campus accommodation summary.</p>
    </div>
  </div>

  <!-- STATS GRID -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-info">
        <h3>Total Students</h3>
        <p><?php echo $totalStudents; ?></p>
      </div>
      <div class="stat-icon" style="color: var(--primary);"><?php echo Icons::users(36); ?></div>
    </div>
    
    <div class="stat-card">
      <div class="stat-info">
        <h3>Total Rooms</h3>
        <p><?php echo $totalRooms; ?></p>
      </div>
      <div class="stat-icon" style="color: var(--info);"><?php echo Icons::home(36); ?></div>
    </div>

    <div class="stat-card">
      <div class="stat-info">
        <h3>Pending Eligibility</h3>
        <p><?php echo $pendingEligibility; ?></p>
      </div>
      <div class="stat-icon" style="color: var(--warning);"><?php echo Icons::warning(36); ?></div>
    </div>

    <div class="stat-card">
      <div class="stat-info">
        <h3>Support Tickets</h3>
        <p><?php echo $totalSupport; ?></p>
      </div>
      <div class="stat-icon" style="color: var(--danger);"><?php echo Icons::ticket(36); ?></div>
    </div>
  </div>

  <div class="panel">
    <h2 style="font-size:1.3rem; font-weight:700; margin-bottom:12px; color:var(--text-heading);">Quick Links & Management</h2>
    <p style="color:var(--text-muted); font-size:0.9rem; margin-bottom:20px;">Use the left sidebar navigation or access quick management links below to check college activities.</p>
    
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px;">
      <a href="admin_students.php" class="action-btn" style="background:#e9ecef; color:var(--text-heading); padding:16px; justify-content:center; border-radius:var(--radius); border:1px solid var(--border);">Manage Students List</a>
      <a href="admin_rooms.php" class="action-btn" style="background:#e9ecef; color:var(--text-heading); padding:16px; justify-content:center; border-radius:var(--radius); border:1px solid var(--border);">Manage Dorm Rooms</a>
      <a href="admin_eligibility.php" class="action-btn" style="background:#e9ecef; color:var(--text-heading); padding:16px; justify-content:center; border-radius:var(--radius); border:1px solid var(--border);">View Approvals Queue</a>
      <a href="admin_support.php" class="action-btn" style="background:#e9ecef; color:var(--text-heading); padding:16px; justify-content:center; border-radius:var(--radius); border:1px solid var(--border);">Process Support Tickets</a>
    </div>
  </div>
</div>

</body>
</html>