<?php
include_once "../controller/userhandler.php";
header('Content-Type: application/json');
$getallusers = new Userhandler();
$alldata = $getallusers->getallusers();
echo json_encode($alldata);
?>