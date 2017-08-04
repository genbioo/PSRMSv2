<?php
// Start the session
session_start();
require_once("dbcontroller.php");
$formID = $_POST['formType'];
$_SESSION['apply_previous'] = $_SERVER['HTTP_REFERER'];
$_SESSION['assessment_tool_ID'] = $formID;
$_SESSION['idpID'] = $_POST['idpID'];
$idp_name = $_POST['idp_name'];
$_SESSION['idp_name'] = $idp_name;
$db_handle = new DBController();

header( "Location: take_form.php" );
?>