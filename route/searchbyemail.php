<?php
include_once "../controller/userhandler.php";
header('Content-Type: application/json');

$searchbyemail = new Userhandler();
$searchdata = $searchbyemail->searchbyemail($_GET);
echo json_encode($searchdata);
?>