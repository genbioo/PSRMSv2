<?php include ('check_credentials.php'); ?>
<html>
    <head>
        <?php
            include("css_include.php");
            require_once("dbcontroller.php");
            $id = $_GET['id'];
            $db_handle = new DBController();
            $question = $db_handle->runFetch("SELECT Question FROM `questions` WHERE QuestionsID = ".$id.";");
            if(!empty($question)) {
        ?>
    </head>
    <body>
        <?php //class="table-striped table-bordered table-hover" ?>
        <table align="center" cellspacing="3" cellpadding="3" width="75%">
            <?php /* BACK BUTTON
            <tr>
            <td>
                <a href="<?php echo ($_SERVER['HTTP_REFERER'])?>">Back</a>
            </td>
            </tr>
            */ ?>
            <tr>
                <td>
                    <h2>Edit Question</h2>
                </td>
            </tr>
            <tr>
                <td>
                <p>This section is for editing an existing question in the database. Please note that once you click 'Submit', all changes done will be irreversible.</p>
                </td>
            </tr>
            <tr>
                <td>
                  <form action="submit_edit_question.php" method="post">
                    <div class="form-group">
                        <label for="question_upd">Question:</label>
                        <textarea class="form-control" rows="5" name="question_upd"><?php foreach ($question as $value) {echo($value['Question']); }}?></textarea>
                        <input type="hidden" name="questionID" value="<?php echo($id); ?>">
                        <input type="hidden" name="previous_page" value="<?php echo($_SERVER['HTTP_REFERER']); ?>">
                        <br><input type="submit" class="btn btn-info" value="Submit">
                    </div>
                  </form>
                </td>
            </tr>
        </table>
    </body>
</html>