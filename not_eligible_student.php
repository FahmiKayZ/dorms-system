<?php

include("includes/connection.php");

$id = $_GET['id'];

mysqli_query($connect,"
UPDATE eligibility
SET status='NO'
WHERE studentID='$id'
");

echo "<script>

alert('Student marked as Not Eligible');

window.location='admin_eligibility.php';

</script>";

?>