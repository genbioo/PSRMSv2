<?php
require_once("dbcontroller.php");
$id = $_POST['formID'];
$answerType = $_POST['answerType'];
$question = $_POST['question_add'];
$db_handle = new DBController();
$previous = $_POST['previous_page'];
if (empty($question)) {
     echo "<script type='text/javascript'>alert('empty field!');
     location='".$previous."';</script>";
} else if (empty($answerType)) {
    echo "<script type='text/javascript'>alert('Please indicate answer type!');
     location='".$previous."';</script>";
} else {
    $question = $db_handle->runUpdate("INSERT INTO `questions` (`QuestionsID`, `Question`, `FORM_FormID`, `Category`, `AnswerType`, `HTML_FORM_HTML_FORM_ID`, `INTAKE_IntakeID`) VALUES (NULL, '".$question."', '".$id."', NULL, '".$answerType."', NULL, NULL)");
    if($db_handle->getUpdateStatus()) {
        echo "<script type='text/javascript'>alert('Add Succesful!');
        location='edit_form.php';
        </script>";
    }
}
?>