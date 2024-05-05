<?php
include_once "../controller/userhandler.php";
$insertuser = new Userhandler();
$data = $insertuser->insertuser($_POST);
echo json_encode($data);
?>