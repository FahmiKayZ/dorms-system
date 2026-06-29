<?php
include 'connection.php';

/* ===========================
   Dashboard Statistics
=========================== */

$totalTickets = mysqli_num_rows(
    mysqli_query($connect,"SELECT * FROM support_tickets")
);

$totalPending = mysqli_num_rows(
    mysqli_query($connect,"
    SELECT * FROM support_tickets
    WHERE status='Pending'
")
);

$totalProgress = mysqli_num_rows(
    mysqli_query($connect,"
    SELECT * FROM support_tickets
    WHERE status='In Progress'
")
);

$totalResolved = mysqli_num_rows(
    mysqli_query($connect,"
    SELECT * FROM support_tickets
    WHERE status='Resolved'
")
);

$totalHigh = mysqli_num_rows(
    mysqli_query($connect,"
    SELECT * FROM support_tickets
    WHERE priority='High'
")
);

/* ===========================
   Ticket List
=========================== */

if(isset($_GET['search']) && $_GET['search']!=""){

    $search = mysqli_real_escape_string($connect,$_GET['search']);

    $result = mysqli_query($connect,"
    SELECT *
    FROM support_tickets
    WHERE
        student_name LIKE '%$search%'
        OR
        student_id LIKE '%$search%'
        OR
        subject LIKE '%$search%'
    ORDER BY created_at DESC
    ");

}else{

    $result = mysqli_query($connect,"
    SELECT *
    FROM support_tickets
    ORDER BY created_at DESC
    ");

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Support Tickets</title>

<link rel="stylesheet" href="css/admin.css">

</head>

<body>
    <body>

<div class="back-button">

    <a href="admin_dashboard.php">

        ← Back to Dashboard

    </a>

</div>

<div class="container">

<div class="container">

<div class="page-header">

    <h1>🎫 Support Ticket Management</h1>

    <p>
        Manage all student and guest support enquiries.
    </p>

</div>
<form method="GET" class="search-bar">

    <input
        type="text"
        name="search"
        placeholder="🔍 Search by Student Name, Student ID or Subject..."
        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"
    >

    <button type="submit">

        Search

    </button>

</form>
<div class="stats-grid">

    <div class="stat-box pending-box">

        <h2><?= $totalPending; ?></h2>

        <p>Pending</p>

    </div>

    <div class="stat-box progress-box">

        <h2><?= $totalProgress; ?></h2>

        <p>In Progress</p>

    </div>

    <div class="stat-box resolved-box">

        <h2><?= $totalResolved; ?></h2>

        <p>Resolved</p>

    </div>

    <div class="stat-box high-box">

        <h2><?= $totalHigh; ?></h2>

        <p>High Priority</p>

    </div>

</div>
<?php

while($row=mysqli_fetch_assoc($result)){

$statusClass="pending";

if($row['status']=="In Progress"){

$statusClass="progress";

}

if($row['status']=="Resolved"){

$statusClass="resolved";

}

?>
<?php

if(mysqli_num_rows($result)==0){

    echo "

    <div style='
        background:white;
        padding:30px;
        border-radius:15px;
        text-align:center;
        color:#ef4444;
        font-weight:bold;
        box-shadow:0 8px 20px rgba(0,0,0,.08);
    '>

    No support tickets found.

    </div>

    ";

}

?>

<div class="ticket-card">

<div class="ticket-info">

<h3>
Ticket #<?= $row['ticket_id']; ?>
</h3>

<p>

<b><?= $row['student_name']; ?></b>

(<?= $row['student_id']; ?>)

</p>

<p>

<?= $row['subject']; ?>

</p>

<span class="status <?= $statusClass ?>">

<?= $row['status']; ?>

</span>

</div>

<a class="view-btn"

href="view_ticket.php?id=<?= $row['ticket_id']; ?>">

View

</a>

</div>

<?php } ?>

</div>

</body>

</html>