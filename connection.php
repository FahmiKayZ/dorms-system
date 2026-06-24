<?php

$connect = mysqli_connect(
    "localhost",
    "root",
    "",
    "dorms_db"
);

if(!$connect){
    die("Connection Failed: " . mysqli_connect_error());
}

?>