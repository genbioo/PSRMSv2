<?php include ('check_credentials.php'); ?>
<html>
    <head>
        <?php include("css_include.php"); ?>
        <?php
        require_once("dbcontroller.php");
        $id = $_GET['id'];
        $db_handle = new DBController();
        $forms = $db_handle->runFetch("SELECT * FROM `form` WHERE FormID = '".$id."'");
        ?>
    </head>
    <body>
        <table align="center" cellspacing="3" cellpadding="3" width="75%">
            <tr>
                <td><h2>Add Question</h2>
                    <p>This section is for adding a new question to an existing form. This question will be added to form: <b><?php
                        if(!empty($forms)) {
                            foreach ($forms as $form) {
                                echo ($form['FormType']);
                            }
                        }?></b>
                    </p>
                </td>
            </tr>
            <form action="submit_add_question.php" method="post">
            <tr>
                <td>
                    <div class="form-group">
                        <label for="question_add"><br>Question:</label>
                        <textarea class="form-control" rows="5" name="question_add"></textarea>
                        <input type="hidden" name="formID" value="<?php echo($id); ?>">
                        <input type="hidden" name="previous_page" value="<?php echo($_SERVER['HTTP_REFERER']); ?>">
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                        <label class="radio-inline"><input type="radio" name="answerType" value="1">Quantitative</label>
                        <label class="radio-inline"><input type="radio" name="answerType" value="2">Qualitative</label>
                        <?php //<label class="radio-inline"><input type="radio" name="optradio">Both</label> ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" class="btn btn-info" value="Submit">
                </td>
            </tr>
            </form>
        </table>
    </body>
</html>