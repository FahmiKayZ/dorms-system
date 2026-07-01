<?php
session_start();
include("includes/connection.php");

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != "admin") {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Ticket not found.");
}

$id = intval($_GET['id']);
$result = mysqli_query($connect, "SELECT * FROM support_tickets WHERE ticket_id=$id");

if (mysqli_num_rows($result) == 0) {
    die("Ticket not found.");
}

$ticket = mysqli_fetch_assoc($result);

if (isset($_POST['save'])) {
    $status = mysqli_real_escape_string($connect, $_POST['status']);
    mysqli_query($connect, "UPDATE support_tickets SET status='$status' WHERE ticket_id=$id");
    header("Location: admin_support.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ticket Details – D.O.R.M.S.</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/admin.css">
<style>
  .ticket-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    background: var(--bg);
    padding: 24px;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    margin-bottom: 24px;
  }
  .meta-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
  .meta-item span {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }
  .meta-item strong {
    font-size: 1.05rem;
    color: var(--text-heading);
  }
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <a href="admin_dashboard.php" class="sidebar-header"><?php echo Icons::dashboard(24); ?> D.O.R.M.S.<span>.</span></a>
  <ul class="sidebar-menu">
    <li><a href="admin_dashboard.php"><?php echo Icons::dashboard(); ?> Dashboard</a></li>
    <li><a href="admin_students.php"><?php echo Icons::users(); ?> Manage Students</a></li>
    <li><a href="admin_rooms.php"><?php echo Icons::home(); ?> Manage Rooms</a></li>
    <li><a href="admin_eligibility.php"><?php echo Icons::check(); ?> Eligibility Approvals</a></li>
    <li class="active"><a href="admin_support.php"><?php echo Icons::ticket(); ?> Support Tickets</a></li>
  </ul>
  <div class="sidebar-footer">
    <a href="index.php?logout=1" class="action-btn btn-delete" style="width:100%; justify-content:center; padding: 10px; display:flex; align-items:center; gap:8px;" onclick="return confirm('Are you sure you want to log out of D.O.R.M.S. Admin?')"><?php echo Icons::logout(); ?> Log Out</a>
  </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
  <div class="page-header">
    <div>
      <h1 style="display:flex; align-items:center; gap:10px;"><?php echo Icons::ticket(28); ?> Ticket Details: #<?php echo htmlspecialchars($ticket['ticket_id']); ?></h1>
      <p style="color:var(--text-muted); font-size:0.95rem;">Review ticket details, priority levels, and reply to student query.</p>
    </div>
    <a href="admin_support.php" class="add-btn" style="background:#e9ecef; color:var(--text-heading); border:1px solid var(--border);">← Back to Tickets</a>
  </div>

  <div class="panel" style="max-width: 800px;">
    <!-- Requester Information -->
    <h2 style="font-size: 1.25rem; font-weight:700; color:var(--text-heading); margin-bottom:16px; display:flex; align-items:center; gap:8px;"><?php echo Icons::user(); ?> Requester Details</h2>
    <div class="ticket-meta-grid">
      <div class="meta-item">
        <span>Full Name</span>
        <strong><?php echo htmlspecialchars($ticket['student_name']); ?></strong>
      </div>
      <div class="meta-item">
        <span>Student ID / Guest</span>
        <strong><?php echo htmlspecialchars($ticket['student_id'] ? $ticket['student_id'] : 'Guest Student'); ?></strong>
      </div>
      <div class="meta-item">
        <span>Email Address</span>
        <strong><?php echo htmlspecialchars($ticket['email']); ?></strong>
      </div>
    </div>

    <!-- Ticket Specifications -->
    <h2 style="font-size: 1.25rem; font-weight:700; color:var(--text-heading); margin-bottom:16px; display:flex; align-items:center; gap:8px;"><?php echo Icons::ticket(); ?> Ticket Content</h2>
    <div class="ticket-meta-grid" style="background:var(--white);">
      <div class="meta-item" style="grid-column: 1 / -1; margin-bottom:12px;">
        <span>Subject</span>
        <strong style="font-size: 1.2rem;"><?php echo htmlspecialchars($ticket['subject']); ?></strong>
      </div>
      
      <div class="meta-item">
        <span>Priority Level</span>
        <div>
          <?php
          $priority = $ticket['priority'];
          $pBadge = 'badge-success';
          if ($priority === 'Medium') $pBadge = 'badge-warning';
          if ($priority === 'High') $pBadge = 'badge-danger';
          ?>
          <span class="badge <?php echo $pBadge; ?>" style="font-size:0.85rem; padding:6px 12px;"><?php echo htmlspecialchars($priority); ?></span>
        </div>
      </div>

      <div class="meta-item">
        <span>Current Status</span>
        <div>
          <?php
          $status = $ticket['status'];
          $sBadge = 'badge-warning';
          if ($status === 'In Progress') $sBadge = 'badge-info';
          if ($status === 'Resolved') $sBadge = 'badge-success';
          ?>
          <span class="badge <?php echo $sBadge; ?>" style="font-size:0.85rem; padding:6px 12px;"><?php echo htmlspecialchars($status); ?></span>
        </div>
      </div>
    </div>

    <!-- Message Description -->
    <div class="form-group" style="margin-bottom:28px;">
      <label>Issue Description</label>
      <textarea readonly style="width:100%; min-height:160px; padding:16px; border-radius:8px; border:1.5px solid var(--border); background:#f8f9fa; font-family:inherit; font-size:0.95rem; line-height:1.5; color:var(--text-body); outline:none; resize:none;"><?php echo htmlspecialchars($ticket['message']); ?></textarea>
    </div>

    <!-- Administrative Response -->
    <h2 style="font-size: 1.25rem; font-weight:700; color:var(--text-heading); margin-bottom:16px; border-top:1px solid var(--border); padding-top:24px; display:flex; align-items:center; gap:8px;"><?php echo Icons::gear(); ?> Administrative Action</h2>
    <form method="POST">
      <div class="form-group">
        <label for="status">Update Status</label>
        <select id="status" name="status" style="max-width:300px;" required>
          <option value="Pending" <?php echo ($ticket['status'] === 'Pending') ? 'selected' : ''; ?>>Pending</option>
          <option value="In Progress" <?php echo ($ticket['status'] === 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
          <option value="Resolved" <?php echo ($ticket['status'] === 'Resolved') ? 'selected' : ''; ?>>Resolved</option>
        </select>
      </div>

      <div style="display:flex; gap:16px; margin-top:20px;">
        <button type="submit" name="save" class="btn-save" style="padding: 12px 28px;">Save Changes</button>
        <a href="admin_support.php" class="action-btn btn-edit" style="text-decoration:none; display:flex; align-items:center; padding:12px 24px;">Cancel</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>