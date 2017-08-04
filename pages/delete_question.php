<?php
    require_once("dbcontroller.php");
    $id = $_GET['id'];
    $db_handle = new DBController();
    $previous = $_SERVER['HTTP_REFERER'];

    echo "<script type='text/javascript'>alert('FUNCTION UNDER CONSTRUCTION!');
    location='".$previous."';
    </script>";
?>
<?php /* NOT YET COMPLETE PHP CODE RUNS EVEN IF PHP CONDITION IS NOT MET
<script>
if (confirm("Are you sure to delete this question? This change is irreversible!") == true) {
    <?php /*
    $question = $db_handle->runUpdate("DELETE FROM `questions` WHERE QuestionsID = ".$id);
    if($db_handle->getUpdateStatus()) {
        echo '
        alert("Delete Succesful!");
        location="'.$previous.'";';
    }*/ /*
    ?>
} else {
    alert('Cancelled!');
    location='".$previous."';
}
</script>*/ ?>
<?php
    /*$question = $db_handle->runUpdate("DELETE FROM `questions` WHERE QuestionsID = ".$id);
    if($db_handle->getUpdateStatus()) {
        echo "<script type='text/javascript'>alert('Delete Succesful!');
        location='".$previous."';
        </script>";
    }*/
?>