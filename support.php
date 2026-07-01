<?php
session_start();
require 'includes/connection.php';

if (!isset($_SESSION['studentID'])) {
    header("Location: login.php");
    exit();
}

$success = "";

if (isset($_POST['submit'])) {
    $student_name = $_SESSION['user']['name'];
    $student_id   = $_SESSION['user']['studentID'];
    $email        = $_SESSION['user']['email'];
    $subject = mysqli_real_escape_string($connect, trim($_POST['subject']));
    $priority = mysqli_real_escape_string($connect, $_POST['priority']);
    $message = mysqli_real_escape_string($connect, trim($_POST['message']));

    $stmt = $connect->prepare("
        INSERT INTO support_tickets (student_id, student_name, email, subject, priority, message)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssssss", $student_id, $student_name, $email, $subject, $priority, $message);

    if ($stmt->execute()) {
        $ticketID = $connect->insert_id;
        $success = "Support Ticket #".$ticketID." submitted successfully!";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Support Center – D.O.R.M.S.</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
<style>
  .support-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
  }
  @media (max-width: 768px) {
    .support-grid {
      grid-template-columns: 1fr;
    }
  }
  .faq-item {
    border-bottom: 1px solid var(--border);
    padding: 16px 0;
  }
  .faq-item:last-child {
    border-bottom: none;
  }
  .faq-item h4 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-heading);
    margin-bottom: 6px;
  }
  .faq-item p {
    font-size: 0.9rem;
    color: var(--text-body);
  }
  .alert-success {
    background: var(--status-yes);
    color: var(--status-yes-t);
    padding: 12px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 20px;
    text-align: center;
    border: 1px solid rgba(0, 158, 96, 0.15);
  }
</style>
</head>
<body>

<nav class="navbar">
  <div class="logo"><?php echo Icons::home(24); ?> D.O.R.M.S.</div>
  <div class="nav-links">
    <a href="dashboard.php">Dashboard</a>
    <a href="floorplan.php">Rooms</a>
    <a href="mybooking.php">My Booking</a>
    <a href="support.php" class="active">Support</a>
  </div>
  <a href="dashboard.php" class="btn-logout" style="background:#e9ecef; color:var(--text-body);">← Back to Dashboard</a>
</nav>

<div class="container">
  <div style="border-bottom:1px solid var(--border); padding-bottom:16px; margin-bottom:10px;">
    <h1 style="font-size:2rem; font-weight:800; color:var(--text-heading);">Support Center</h1>
    <p style="color:var(--text-muted); font-size:0.95rem;">Have questions or running into issues? Review the FAQs or open a support ticket.</p>
  </div>

  <div class="support-grid">
    <!-- FAQ Card -->
    <div class="card">
      <h2 style="font-size:1.4rem; font-weight:700; margin-bottom:16px; border-bottom:1px solid var(--border); padding-bottom:8px;">Frequently Asked Questions</h2>
      <div class="faq-item">
        <h4>Can I cancel my booking?</h4>
        <p>Yes. You can cancel your active booking reservation directly from the "My Booking" tab at any time.</p>
      </div>
      <div class="faq-item">
        <h4>Can I change my room?</h4>
        <p>To change rooms, you must cancel your current active room booking first, then browse and book a new room.</p>
      </div>
      <div class="faq-item">
        <h4>How long does approval take?</h4>
        <p>All room bookings are processed by administrators. You will see your status update instantly once approved.</p>
      </div>
      <div class="faq-item">
        <h4>I forgot my password or need profile changes.</h4>
        <p>Please contact the residential college administration office for password recovery and account adjustments.</p>
      </div>
    </div>

    <!-- Ticket Card -->
    <div class="card">
      <h2 style="font-size:1.4rem; font-weight:700; margin-bottom:16px; border-bottom:1px solid var(--border); padding-bottom:8px;">Submit Support Ticket</h2>
      
      <?php if ($success): ?>
        <div class="alert-success"><?php echo Icons::check(); ?> <?php echo htmlspecialchars($success); ?></div>
      <?php endif; ?>

      <div style="background:var(--bg); border:1px solid var(--border); padding:12px; border-radius:8px; font-size:0.85rem; color:var(--text-body); margin-bottom:20px;">
        Logged in as: <strong><?php echo htmlspecialchars($_SESSION['user']['name']); ?></strong> (<?php echo htmlspecialchars($_SESSION['user']['studentID']); ?>)
      </div>

      <form method="POST" action="support.php">
        <div class="form-group">
          <label for="subject">Subject / Issue Title</label>
          <input type="text" id="subject" name="subject" placeholder="Brief summary of your query" required>
        </div>

        <div class="form-group">
          <label for="priority">Priority Level</label>
          <select id="priority" name="priority" required>
            <option value="Low">Priority: Low</option>
            <option value="Medium" selected>Priority: Medium</option>
            <option value="High">Priority: High</option>
          </select>
        </div>

        <div class="form-group">
          <label for="message">Message / Details</label>
          <textarea id="message" name="message" rows="5" placeholder="Please describe your issue in detail..." required></textarea>
        </div>

        <button type="submit" name="submit" class="btn-submit" style="width:100%;">Submit Support Ticket</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>