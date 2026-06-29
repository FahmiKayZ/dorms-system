<?php

include("connection.php");

$id=$_GET['id'];

mysqli_query($connect,"
UPDATE eligibility
SET status='YES'
WHERE studentID='$id'
");

echo "<script>

alert('Student Approved Successfully');

window.location='admin_eligibility.php';

</script>";

?>