<?php
session_start();
require 'connection.php';
?>

<?php

$success = "";

if(isset($_POST['submit'])){

    $student_name = $_SESSION['user']['name'];
    $student_id   = $_SESSION['user']['studentID'];
    $email        = $_SESSION['user']['email'];
    $subject = trim($_POST['subject']);
    $priority = $_POST['priority'];
    $message = trim($_POST['message']);

    $stmt = $connect->prepare("
    INSERT INTO support_tickets
    (student_id, student_name, email, subject, priority, message)
    VALUES (?, ?, ?, ?, ?, ?)
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

    <title>Support Center | D.O.R.M.S.</title>

    <link rel="stylesheet" href="css/homepage.css">

</head>

<body>

<nav class="navbar">

    <a href="index.php" class="logo">
        🏠 D.O.R.M.S.
    </a>

    <ul class="nav-links">

        <li><a href="index.php">Home</a></li>

        <li><a href="rooms.php">Rooms</a></li>

        <li><a href="support.php" class="active">Support</a></li>

    </ul>

</nav>

<section class="support-page">

    <div class="support-header">

        <h1>Support Center</h1>

        <p>
            Need help? Submit a support ticket and our administrator will assist you as soon as possible.
        </p>

    </div>

    <div class="support-container">

        <!-- FAQ -->

        <div class="faq-card">

            <h2>Frequently Asked Questions</h2>

            <div class="faq-item">
                <h4>Can I cancel my booking?</h4>
                <p>Yes. You may cancel your booking from My Booking.</p>
            </div>

            <div class="faq-item">
                <h4>Can I change my room?</h4>
                <p>Please cancel your current booking before booking another room.</p>
            </div>

            <div class="faq-item">
                <h4>How long does approval take?</h4>
                <p>Room approval is usually immediate if the room is available.</p>
            </div>

            <div class="faq-item">
                <h4>I forgot my password.</h4>
                <p>Please contact the administrator.</p>
            </div>

        </div>

        <!-- Ticket -->

        <div class="ticket-card">

            <h2>Submit Ticket</h2>
            <?php if($success): ?>
        <div class="success-message">
    <?= $success ?>
            </div>
            <?php endif; ?>

                <div class="user-info">

                    Logged in as<br>

                    <strong><?= $_SESSION['user']['name']; ?></strong><br>

                    <?= $_SESSION['user']['studentID']; ?>

            </div>

                <form method="POST" action="">

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

    <option value="Low">
        🟢 Low
    </option>

    <option value="Medium" selected>
        🟡 Medium
    </option>

    <option value="High">
        🔴 High
    </option>

</select>

                <textarea
                    name="message"
                    rows="6"
                    placeholder="Describe your issue..."
                    required
                ></textarea>

                <button type="submit" name="submit">
                    Submit Ticket
                </button>
            </form>
        </div>
    </div>
</section>
</body>
</html>