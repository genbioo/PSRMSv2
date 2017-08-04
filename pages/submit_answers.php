<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
$post = $_POST; //$key for this array is in the format x-y where x = answertype & y = questionID
$temp_answertype = ""; //temporary answertype variable
$temp_qid = "";   //temporary id variable
$query = "";
$question_ids = array();
$question_answers = array();
$unansweredQuestion = array();
$idp_form_answers_id = "";


foreach($post as $key => $results) {
    //if $key has 'q-' prefix (which is for questions), add to $question_ids array
    if (strpos($key, 'q-') !== false) {
        $question_ids[$key] = $results;
    } else if (strpos($key, '1-') !== false || strpos($key, '2-') !== false) { //else if $key has '1-' or '2-' prefix (which is for answers), add to $question_answers array
        $question_answers[$key] = $results;
    }
}

foreach($question_ids as $result) {
    //if a key (a question id) in question_answers does not exist; it means it is left unanswered
    if(!isset($question_answers['1-'.$result]) || !isset($question_answers['1-'.$result])) {
        $unansweredQuestion[] = $result;
    }
}

$db_handle->runUpdate("INSERT INTO `form_answers` (`FORM_ANSWERS_ID`, `USER_UserID`, `FORM_FormID`, `DateTaken`, `IDP_IDP_ID`, `UnansweredItems`) VALUES (NULL, '".$_SESSION['userID']."', '".$_SESSION['assessment_tool_ID']."', CURRENT_TIMESTAMP, ".$_SESSION['idpID'].", '".implode(',', $unansweredQuestion)."');"); //implode format => id,id,id,...,id
$idp_form_answers_id = $db_handle->getLastInsertID();

foreach($question_answers as $key => $qa) {
    $tempAnsType = substr($key, 0, 1); //remove string after index 1; ex key: '1-199' where 1 is the answer type
    $tempID = substr($key, 2); //remove first two chars of key. ex key: '1-199' where 199 is the question id
    if($tempAnsType === '1') {
        $query .= "INSERT INTO `answers_quanti` (`ANSWERS_QUANTI_ID`, `Answer`, `QUESTIONS_QuestionsID`, `FORM_ANWERS_FORM_ANSWERS_ID`, `INTAKE_ANSWERS_INTAKE_ANSWERS_ID`) VALUES ( NULL, '".$qa."', '".$tempID."', '".$idp_form_answers_id."', NULL);";
    } else if($tempAnsType === '2') {
        $query .= "INSERT INTO `answers_quali` (`ANSWERS_QUALI_ID`, `Answer`, `QUESTIONS_QuestionsID`, `FORM_ANSWERS_FORM_ANSWERS_ID`, `INTAKE_ANSWERS_INTAKE_ANSWERS_ID`) VALUES ( NULL, '".$qa."', '".$tempID."', '".$idp_form_answers_id."', NULL);";
    }
}
$db_handle->runUpdate($query);
if($db_handle->getUpdateStatus()) {
    echo "<script type='text/javascript'>alert('Answers submitted!');
    location='".$_SESSION['apply_previous']."';
    </script>";
}
?>