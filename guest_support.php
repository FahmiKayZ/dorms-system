<?php

require 'connection.php';

$success = "";
$error   = "";

if(isset($_POST['submit'])){

    $student_name = trim($_POST['student_name'] ?? '');
    $student_id   = trim($_POST['student_id'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $subject      = trim($_POST['subject'] ?? '');
    $priority     = $_POST['priority'] ?? 'Medium';
    $message      = trim($_POST['message'] ?? '');

    $allowedPriorities = ['Low', 'Medium', 'High'];

    if($student_name === "" || $email === "" || $subject === "" || $message === ""){

        $error = "Please fill in all required fields before submitting.";

    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){

        $error = "Please enter a valid email address.";

    } elseif(!in_array($priority, $allowedPriorities, true)){

        $error = "Invalid priority selected.";

    } else {

        $stmt = $connect->prepare("
            INSERT INTO support_tickets
            (student_id, student_name, email, subject, priority, message, status)
            VALUES (?, ?, ?, ?, ?, ?, 'Pending')
        ");

        $stmt->bind_param(
            "ssssss",
            $student_id,
            $student_name,
            $email,
            $subject,
            $priority,
            $message
        );

        if($stmt->execute()){

            $ticketID = $connect->insert_id;

            $success = "Your Support Ticket (#".$ticketID.") has been submitted successfully.";

            // clear fields after a successful submit
            $student_name = $student_id = $email = $subject = $message = "";
            $priority = "Medium";

        } else {

            $error = "Something went wrong while submitting your ticket. Please try again.";

        }

        $stmt->close();

    }

}

// FAQ data — easy to expand later
$faqs = [
    [
        'q' => 'I cannot login.',
        'a' => 'Please submit a support ticket and our administrator will assist you.'
    ],
    [
        'q' => 'I cannot register.',
        'a' => 'Please ensure your Student ID and Email are correct.'
    ],
    [
        'q' => 'I forgot my password.',
        'a' => 'Our administrator will help reset your password.'
    ],
    [
        'q' => 'How long will it take?',
        'a' => 'Most support tickets are answered within 24 hours.'
    ],
];

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Guest Support | D.O.R.M.S.</title>

<link rel="stylesheet" href="css/homepage.css">

</head>

<body>

<nav class="navbar">
  <a href="index.php" class="nav-brand">
    <div class="nav-brand-icon">🏠</div>
    <span class="nav-brand-text">D.O.R.M.S<span>.</span></span>
  </a>

  <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="guest_support.php" class="active">Support</a></li>
  </ul>

  <div class="nav-actions">
    <a href="register.php" class="btn-primary">Register</a>
  </div>
</nav>

<section class="support-page">

<div class="support-header">

<h1>Guest Support Center</h1>

<p>

Need help before logging in? Submit a support ticket and our administrator will contact you.

</p>

</div>

<div class="support-container">
    <div class="faq-card">

    <h2>Frequently Asked Questions</h2>

    <?php foreach($faqs as $i => $faq){ ?>

        <div class="faq-item">

            <h4>
                <button
                    type="button"
                    onclick="toggleFaq(<?= $i ?>)"
                    style="background:none;border:none;cursor:pointer;font:inherit;color:inherit;text-align:left;width:100%;display:flex;justify-content:space-between;align-items:center;padding:0;"
                    aria-expanded="false"
                    aria-controls="faq-answer-<?= $i ?>"
                >
                    <span><?= htmlspecialchars($faq['q']) ?></span>
                    <span id="faq-icon-<?= $i ?>">+</span>
                </button>
            </h4>

            <p id="faq-answer-<?= $i ?>" style="display:none;">
                <?= htmlspecialchars($faq['a']) ?>
            </p>

        </div>

    <?php } ?>

</div>
<div class="ticket-card">

    <h2>Submit Support Ticket</h2>

    <?php if($error){ ?>

    <div class="success-message" style="background:#fee2e2;color:#991b1b;border-color:#fca5a5;">

        ⚠ <?= htmlspecialchars($error); ?>

    </div>

    <?php } ?>

    <?php if($success){ ?>

    <div class="success-message">

        ✓ <?= htmlspecialchars($success); ?>

    </div>

    <?php } ?>

    <form method="POST">

        <input
            type="text"
            name="student_name"
            placeholder="Full Name"
            value="<?= htmlspecialchars($student_name ?? '') ?>"
            required
        >

        <input
            type="text"
            name="student_id"
            placeholder="Student ID (Optional)"
            value="<?= htmlspecialchars($student_id ?? '') ?>"
        >

        <input
            type="email"
            name="email"
            placeholder="Email Address"
            value="<?= htmlspecialchars($email ?? '') ?>"
            required
        >

        <input
            type="text"
            name="subject"
            placeholder="Subject"
            value="<?= htmlspecialchars($subject ?? '') ?>"
            required
        >

        <select
            name="priority"
            required
        >

            <option value="Low" <?= (($priority ?? '') === 'Low') ? 'selected' : '' ?>>🟢 Priority: Low</option>

            <option value="Medium" <?= (($priority ?? 'Medium') === 'Medium') ? 'selected' : '' ?>>🟡 Priority: Medium</option>

            <option value="High" <?= (($priority ?? '') === 'High') ? 'selected' : '' ?>>🔴 Priority: High</option>

        </select>

        <textarea
            name="message"
            rows="6"
            placeholder="Describe your issue..."
            maxlength="1000"
            oninput="updateCount(this)"
            required
        ><?= htmlspecialchars($message ?? '') ?></textarea>

        <div style="text-align:right;font-size:0.75rem;color:var(--text-muted);margin-top:-10px;" id="charCount">
            <?= strlen($message ?? '') ?> / 1000 characters
        </div>

        <button
            type="submit"
            name="submit"
        >

            📩 Submit Ticket

        </button>

    </form>

</div>
</div>
</section>

<script>
  // FAQ accordion — only one open at a time
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

  // Character counter for message textarea
  function updateCount(textarea) {
    const count   = textarea.value.length;
    const max     = textarea.getAttribute('maxlength');
    const display = document.getElementById('charCount');
    display.textContent = count + ' / ' + max + ' characters';
    display.style.color = count > max * 0.9 ? '#d64545' : '';
  }
</script>

</body>
</html>