<?php
session_start();
require_once("dbcontroller.php");
$type = $_GET['type'];
$id = $_POST['formID'];
$post = array_values($_POST);   //contains question_addx, answerTypex, where(x is 0++) and $_POST['formID'] as the last element
$post_len = count($post)-1;     //subtract one because the last element is $_POST['formID']; we will not include this in the loop later
$db_handle = new DBController();
$previous = $_SESSION['previous'];
$q_ansType = array();           //array for html_form ids to be used in query
$q_ansType_len = 0;
$query = "";

//converting $post array to a 2d array that contains [question, answerType] per entry
for($i = 0; $i < $post_len; $i += 2) {
    $q_ansType[] = array(nl2br($post[$i]), $post[$i+1]);
}
$q_ansType_len = count($q_ansType); //update

if($type === 'intake') {
    for($k = 0; $k < $q_ansType_len; $k++) {
        $query .= "INSERT INTO `questions` (`QuestionsID`, `Question`, `FORM_FormID`, `Category`, `AnswerType`, `HTML_FORM_HTML_FORM_ID`, `INTAKE_IntakeID`, `Dialect`) VALUES (NULL, '".$q_ansType[$k][0]."', NULL , NULL, '".$q_ansType[$k][1]."', NULL, '".$id."', NULL);";
    }
} else if ($type === 'assessment') {
    for($k = 0; $k < $q_ansType_len; $k++) {
        $query .= "INSERT INTO `questions` (`QuestionsID`, `Question`, `FORM_FormID`, `Category`, `AnswerType`, `HTML_FORM_HTML_FORM_ID`, `INTAKE_IntakeID`, `Dialect`) VALUES (NULL, '".$q_ansType[$k][0]."', '".$id."', NULL, '".$q_ansType[$k][1]."', NULL, NULL, NULL);";
    }
}

$question = $db_handle->runUpdate($query);

if($db_handle->getUpdateStatus()) {
    echo "<script type='text/javascript'>alert('Add Succesful!');
    location='".$previous."';
    </script>";
}
?>