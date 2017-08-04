<?php
require_once("dbcontroller.php");
$id = $_POST['questionID'];
$question = $_POST['question_upd'];
$db_handle = new DBController();
$query;
?>