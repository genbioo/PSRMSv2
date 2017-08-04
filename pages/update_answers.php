<?php
session_start();
require_once("dbcontroller.php");
$form_answers_id = $_GET['id'];
$db_handle = new DBController();
$post = $_POST; //$key for this array is in the format x-y where x = answertype & y = questionID
$temp_answertype = ""; //temporary answertype variable
$temp_qid = "";   //temporary id variable
$query = "";
$question_ids = array();
$question_answers = array();
$unansweredQuestion = array();
$old_unanswered_array = array();
$old_unansweredItems = $db_handle->runFetch('SELECT form_answers.UnansweredItems FROM form_answers WHERE form_answers.FORM_ANSWERS_ID = '.$form_answers_id);
//convert associative array $old_unansweredItems to indexed array $old_unanswered_array
foreach($old_unansweredItems as $o_ua) {
    $old_unanswered_array = explode(',',$o_ua['UnansweredItems']);
}
foreach($post as $key => $results) {
    //if $key has 'q-' prefix (which is for questions), add to $question_ids array
    if (strpos($key, 'q-') !== false) {
        $question_ids[$key] = $results;
    } else if (strpos($key, '1-') !== false || strpos($key, '2-') !== false) { //else if $key has '1-' or '2-' prefix (which is for answers), add to $question_answers array
        $question_answers[$key] = $results;
    }
}

$count_ = count($old_unanswered_array);
for($i = 0; $i < $count_; $i++) {
    $quanti_answer_exists = isset($question_answers['1-'.$old_unanswered_array[$i]]);
    $quali_answer_exists = isset($question_answers['2-'.$old_unanswered_array[$i]]);
    
    //if a '1-' or '2-' prefixed key exists in $question_answers; it means an answer is now provided to this questionID
    //questionID can be taken from the key. ex key: '1-199' where 1 is the answerType and 199 is the questionID
    if($quanti_answer_exists || $quali_answer_exists) {
        if($quanti_answer_exists) {
            $query .= "INSERT INTO `answers_quanti` (`ANSWERS_QUANTI_ID`, `Answer`, `QUESTIONS_QuestionsID`, `FORM_ANWERS_FORM_ANSWERS_ID`, `INTAKE_ANSWERS_INTAKE_ANSWERS_ID`) VALUES ( NULL, '".$question_answers['1-'.$old_unanswered_array[$i]]."', '".$old_unanswered_array[$i]."', '".$form_answers_id."', NULL); ";
        } else if ($quali_answer_exists) {
            $query .= "INSERT INTO `answers_quali` (`ANSWERS_QUALI_ID`, `Answer`, `QUESTIONS_QuestionsID`, `FORM_ANSWERS_FORM_ANSWERS_ID`, `INTAKE_ANSWERS_INTAKE_ANSWERS_ID`) VALUES ( NULL, '".$question_answers['2-'.$old_unanswered_array[$i]]."', '".$old_unanswered_array[$i]."', '".$form_answers_id."', NULL); ";
        }
    } else {
        $unansweredQuestion[] = $old_unanswered_array[$i];
    }
}
$unanswered_question_to_query = (empty($unansweredQuestion)) ? "NULL" : implode(',',$unansweredQuestion);
$db_handle->runUpdate("UPDATE `form_answers` SET `UnansweredItems` = '".$unanswered_question_to_query."' WHERE `form_answers`.`FORM_ANSWERS_ID` = ".$form_answers_id."; ".$query);
if($db_handle->getUpdateStatus()) {
    echo "<script type='text/javascript'>alert('Answers submitted!');
    location='assessment.php';
    </script>";
}
?>