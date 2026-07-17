<?php
require 'includes/connection.php';

$success = "";
$error   = "";

if (isset($_POST['submit'])) {
    $student_name = mysqli_real_escape_string($connect, trim($_POST['student_name'] ?? ''));
    $student_id   = mysqli_real_escape_string($connect, trim($_POST['student_id'] ?? ''));
    $email        = mysqli_real_escape_string($connect, trim($_POST['email'] ?? ''));
    $subject      = mysqli_real_escape_string($connect, trim($_POST['subject'] ?? ''));
    $priority     = mysqli_real_escape_string($connect, $_POST['priority'] ?? 'Medium');
    $message      = mysqli_real_escape_string($connect, trim($_POST['message'] ?? ''));

    $allowedPriorities = ['Low', 'Medium', 'High'];

    if ($student_name === "" || $email === "" || $subject === "" || $message === "") {
        $error = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (!in_array($priority, $allowedPriorities, true)) {
        $error = "Invalid priority selected.";
    } else {
        $stmt = $connect->prepare("
            INSERT INTO support_tickets (student_id, student_name, email, subject, priority, message, status)
            VALUES (?, ?, ?, ?, ?, ?, 'Pending')
        ");
        $stmt->bind_param("ssssss", $student_id, $student_name, $email, $subject, $priority, $message);

        if ($stmt->execute()) {
            $ticketID = $connect->insert_id;
            $success = "Your Support Ticket (#".$ticketID.") has been submitted successfully.";
            $student_name = $student_id = $email = $subject = $message = "";
            $priority = "Medium";
        } else {
            $error = "Something went wrong while submitting your ticket. Please try again.";
        }
        $stmt->close();
    }
}

$faqs = [
    [
        'q' => 'I cannot login.',
        'a' => 'If you are a student, ensure your student ID is registered. If you forgot your password, contact college administration to reset it.'
    ],
    [
        'q' => 'I cannot register.',
        'a' => 'Make sure you are entering a valid Student ID. Student IDs must be unique. If you see an error, check if you already registered.'
    ],
    [
        'q' => 'How do I check my eligibility?',
        'a' => 'You can check your eligibility status directly from the "Check Eligibility" link in the navbar without signing in.'
    ],
    [
        'q' => 'How long will it take to get a reply?',
        'a' => 'Most administrative requests and support tickets are processed within 24 to 48 hours.'
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Guest Support – D.O.R.M.S.</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/homepage.css">
<style>
  .support-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
  }
  @media (max-width: 768px) {
    .support-grid {
      grid-template-columns: 1fr;
    }
  }
  .faq-card {
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 30px;
    box-shadow: 0 4px 15px var(--shadow);
  }
  .faq-item {
    border-bottom: 1px solid var(--border);
    padding: 16px 0;
  }
  .faq-item:last-child {
    border-bottom: none;
  }
  .faq-item h4 button {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-heading);
    transition: color 0.2s ease;
  }
  .faq-item h4 button:hover {
    color: var(--bg-nav);
  }
  .faq-item p {
    font-size: 0.9rem;
    color: var(--text-body);
    margin-top: 8px;
    line-height: 1.4;
  }
  .alert {
    padding: 12px;
    border-radius: var(--radius);
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 20px;
    text-align: center;
    border: 1px solid;
  }
  .alert-error {
    background: #f8d7da;
    color: #721c24;
    border-color: #f5c6cb;
  }
  .alert-success {
    background: #d4edda;
    color: #155724;
    border-color: #c3e6cb;
  }
</style>
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="nav-brand">
    <div class="nav-brand-icon"><?php echo Icons::home(24); ?></div>
    <span class="nav-brand-text">D.O.R.M.S<span>.</span></span>
  </a>
  <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="guest_support.php" class="active">Support</a></li>
  </ul>
  <div class="nav-actions">
    <a href="login.php" class="btn-login">Log In</a>
    <a href="register.php" class="btn-primary">Register</a>
  </div>
</nav>

<div style="text-align:center; padding: 40px 20px 0 20px;">
  <h1 style="font-size:2rem; font-weight:800; color:var(--text-heading); margin-bottom:8px;">Guest Support Center</h1>
  <p style="color:var(--text-muted); font-size:0.95rem; max-width:600px; margin:0 auto;">Have issues registering or logging into D.O.R.M.S.? Open a support ticket below.</p>
</div>

<div class="support-grid">
  <!-- FAQ Card -->
  <div class="faq-card">
    <h2 style="font-size:1.4rem; font-weight:700; color:var(--text-heading); margin-bottom:16px; border-bottom:1px solid var(--border); padding-bottom:8px;">Frequently Asked Questions</h2>
    <?php foreach ($faqs as $i => $faq): ?>
      <div class="faq-item">
        <h4>
          <button type="button" onclick="toggleFaq(<?= $i ?>)" style="background:none;border:none;cursor:pointer;font:inherit;color:inherit;text-align:left;width:100%;display:flex;justify-content:space-between;align-items:center;padding:0;" aria-expanded="false" aria-controls="faq-answer-<?= $i ?>">
            <span><?= htmlspecialchars($faq['q']) ?></span>
            <span id="faq-icon-<?= $i ?>" style="font-size:1.25rem;">+</span>
          </button>
        </h4>
        <p id="faq-answer-<?= $i ?>" style="display:none;"><?= htmlspecialchars($faq['a']) ?></p>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Ticket Form Container -->
  <div class="form-container" style="margin: 0; width: 100%; max-width: 100%;">
    <div class="form-header" style="text-align:left; margin-bottom:20px;">
      <h2 style="font-size:1.4rem; border-bottom:1px solid var(--border); padding-bottom:8px;">Submit Support Ticket</h2>
    </div>

    <?php if ($error): ?>
      <div class="alert alert-error"><?php echo Icons::warning(); ?> <?php echo htmlspecialchars($error); ?></div>
    <?php elseif ($success): ?>
      <div class="alert alert-success"><?php echo Icons::check(); ?> <?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label for="student_name">Full Name</label>
        <input type="text" id="student_name" name="student_name" placeholder="John Doe" value="<?php echo htmlspecialchars($student_name ?? ''); ?>" required>
      </div>

      <div class="form-group">
        <label for="student_id">Student ID (Optional)</label>
        <input type="text" id="student_id" name="student_id" placeholder="e.g. 2026123456" value="<?php echo htmlspecialchars($student_id ?? ''); ?>">
      </div>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="example@student.uitm.edu.my" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
      </div>

      <div class="form-group">
        <label for="subject">Subject</label>
        <input type="text" id="subject" name="subject" placeholder="Brief summary of request" value="<?php echo htmlspecialchars($subject ?? ''); ?>" required>
      </div>

      <div class="form-group">
        <label for="priority">Priority Level</label>
        <select id="priority" name="priority" required>
          <option value="Low" <?php echo (($priority ?? '') === 'Low') ? 'selected' : ''; ?>>Priority: Low</option>
          <option value="Medium" <?php echo (($priority ?? 'Medium') === 'Medium') ? 'selected' : ''; ?>>Priority: Medium</option>
          <option value="High" <?php echo (($priority ?? '') === 'High') ? 'selected' : ''; ?>>Priority: High</option>
        </select>
      </div>

      <div class="form-group">
        <label for="message">Message Details</label>
        <textarea id="message" name="message" rows="5" placeholder="Describe your issue in detail..." maxlength="1000" oninput="updateCount(this)" required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
        <div style="text-align:right; font-size:0.75rem; color:var(--text-muted); margin-top:2px;" id="charCount">
          <?php echo strlen($message ?? ''); ?> / 1000 characters
        </div>
      </div>

      <button type="submit" name="submit" class="form-submit">Submit Ticket</button>
    </form>
  </div>
</div>

<script>
  function toggleFaq(index) {
    const answer = document.getElementById('faq-answer-' + index);
    const icon   = document.getElementById('faq-icon-' + index);
    const isOpen = answer.style.display === 'block';

    document.querySelectorAll('[id^="faq-answer-"]').forEach((el) => {
      el.style.display = 'none';
    });
    document.querySelectorAll('[id^="faq-icon-"]').forEach((el) => {
      el.textContent = '+';
    });

    if (!isOpen) {
      answer.style.display = 'block';
      icon.textContent = '×';
    }
  }

  function updateCount(textarea) {
    const count   = textarea.value.length;
    const max     = textarea.getAttribute('maxlength');
    const display = document.getElementById('charCount');
    display.textContent = count + ' / ' + max + ' characters';
    display.style.color = count > max * 0.9 ? '#dc3545' : '';
  }
</script>
</body>
</html>