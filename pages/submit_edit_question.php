<?php
require_once("dbcontroller.php");
$id = $_POST['questionID'];
$question = addslashes($_POST['question_upd']);
$db_handle = new DBController();
$previous = $_POST['previous_page'];
if (empty($question)) {
     echo "<script type='text/javascript'>alert('empty field!');
     location='".$previous."';</script>";
} else {
    $question = $db_handle->runUpdate("UPDATE `questions` SET `Question` = '".$question."' WHERE `questions`.`QuestionsID` = ".$id);

    if($db_handle->getUpdateStatus()) {
        echo "<script type='text/javascript'>alert('Update Succesful!');
        location='edit_form.php';
        </script>";
    }
}
?>