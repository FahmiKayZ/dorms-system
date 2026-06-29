<?php

require 'connection.php';

$success = "";

if(isset($_POST['submit'])){

    $student_name = trim($_POST['student_name']);
    $student_id   = trim($_POST['student_id']);
    $email        = trim($_POST['email']);
    $subject      = trim($_POST['subject']);
    $priority     = $_POST['priority'];
    $message      = trim($_POST['message']);

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

    }

    $stmt->close();

}

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

<a href="index.php" class="logo">
🏠 D.O.R.M.S.
</a>

<ul class="nav-links">

<li><a href="index.php">Home</a></li>

<li><a href="register.php">Register</a></li>

<li><a href="guest_support.php" class="active">Support</a></li>

</ul>

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

    <div class="faq-item">

        <h4>I cannot login.</h4>

        <p>
            Please submit a support ticket and our administrator will assist you.
        </p>

    </div>

    <div class="faq-item">

        <h4>I cannot register.</h4>

        <p>
            Please ensure your Student ID and Email are correct.
        </p>

    </div>

    <div class="faq-item">

        <h4>I forgot my password.</h4>

        <p>
            Our administrator will help reset your password.
        </p>

    </div>

    <div class="faq-item">

        <h4>How long will it take?</h4>

        <p>
            Most support tickets are answered within 24 hours.
        </p>

    </div>

</div>
<div class="ticket-card">

    <h2>Submit Support Ticket</h2>

    <?php if($success){ ?>

    <div class="success-message">

        <?= $success; ?>

    </div>

    <?php } ?>

    <form method="POST">

        <input
            type="text"
            name="student_name"
            placeholder="Full Name"
            required
        >

        <input
            type="text"
            name="student_id"
            placeholder="Student ID (Optional)"
        >

        <input
            type="email"
            name="email"
            placeholder="Email Address"
            required
        >

        <input
            type="text"
            name="subject"
            placeholder="Subject"
            required
        >

        <select
            name="priority"
            required
        >

            <option value="Low">🟢 Low</option>

            <option value="Medium" selected>🟡 Medium</option>

            <option value="High">🔴 High</option>

        </select>

        <textarea
            name="message"
            rows="6"
            placeholder="Describe your issue..."
            required
        ></textarea>

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
</body>
</html>