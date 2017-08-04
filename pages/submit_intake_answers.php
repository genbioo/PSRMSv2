<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
$idp_id = $_GET['id'];
$age_group = $_GET['ag'];
$post = $_POST; //$key for this array is in the format x-y where x = answertype & y = questionID
$temp_answertype = ""; //temporary answertype variable
$temp_qid = "";   //temporary id variable
$query = "";
$intakes = $db_handle->runFetch("SELECT * FROM `intake` WHERE DISASTER_DisasterID = ".$_SESSION['disaster_id']." AND AgeGroup = ".$age_group);
foreach($intakes as $info) {
    $intakeID = $info['IntakeID'];
}

$db_handle->runUpdate("INSERT INTO `intake_answers` (`INTAKE_ANSWERS_ID`, `INTAKE_IntakeID`, `IDP_IDP_ID`, `USER_UserID`, `Date_taken`) VALUES ('', '".$intakeID."', '".$idp_id."', '".$_SESSION['userID']."', CURRENT_TIMESTAMP)");
$idp_form_answers_id = $db_handle->getLastInsertID();

foreach($post as $key => $answers) {
    $temp_answertype = substr($key, 0, 1);
    $temp_qid = substr($key, 2);
    if($temp_answertype === '1') {
        $query .= "INSERT INTO `answers_quanti` (`ANSWERS_QUANTI_ID`, `Answer`, `QUESTIONS_QuestionsID`, `FORM_ANWERS_FORM_ANSWERS_ID`, `INTAKE_ANSWERS_INTAKE_ANSWERS_ID`) VALUES ( NULL, '".$answers."', '".$temp_qid."', NULL, '".$idp_form_answers_id."');";
    } else if($temp_answertype === '2') {
        if($answers == '') {
            $query .= "INSERT INTO `answers_quali` (`ANSWERS_QUALI_ID`, `Answer`, `QUESTIONS_QuestionsID`, `FORM_ANSWERS_FORM_ANSWERS_ID`, `INTAKE_ANSWERS_INTAKE_ANSWERS_ID`) VALUES ( NULL, 'N/A', '".$temp_qid."', NULL, '".$idp_form_answers_id."');";
        }
    }
    $temp_answertype = "";
    $temp_qid = "";
}
$db_handle->runUpdate($query);
if($db_handle->getUpdateStatus()) {
    echo "<script type='text/javascript'>alert('Answers submitted!');
    location='".$_SESSION['intake_previous']."';
    </script>";
}
?>