<html>
    <head>
        <?php 
        include("css_include.php");
        include("core_include.php");
        $prev = $_SERVER['HTTP_REFERER'];
        ?>
    </head>
    <body>
    <?php
    require_once("dbcontroller.php");
    $id = $_GET['id'];
    $name = $_GET['name'];
    $db_handle = new DBController();
    $questions = $db_handle->runFetch("SELECT * FROM `questions` WHERE FORM_FormID = ".$id.";");
    $instructions = $db_handle->runFetch("SELECT * FROM `form` WHERE FormID = ".$id);
    $fetchcount = $db_handle->getFetchCount();
    ?>
    <?php //class="table-striped table-bordered table-hover" ?><div class="form-group">
            <table align="center" cellspacing="3" cellpadding="3" width="90%" class="table-responsive">
            <tr>
                <td>
                    <a href="dashboard.php">Home</a>
                </td>
            </tr>
            <tr>
                <td><br><h4><?php echo 'For form: <b>'.($name).'</b>'; ?></h4></td>
            </tr>
            <tr>
                <td><h4>Instructions:</h4><h4><?php if(!empty($instructions)) { foreach ($instructions as $instruction) { echo $instruction['Instructions'];}} ?></h4></td>
            </tr>
            <tr>
                <?php if ($db_handle->getFetchCount() == 1) {
                    echo '<td align="left"><h2>Question &nbsp;<a href="add_question.php?id='.$id.'" class="btn btn-info btn-sm" role="button">add question</a></h2></td>';
                } else {
                    echo '<td align="left">
                    <h2>
                    <input type="checkbox" onClick="toggle(this)" name="toggleCheckbox" style="display:none;"/>Questions &nbsp;<a href="add_question.php?id='.$id.'" class="btn btn-info btn-sm" role="button">add question</a> &nbsp;
                    <button id="edit-questions-button" onClick="show_edit_interface()" type="button" class="btn btn-default btn-sm">Edit questions</button>
                    <input id="add-answer-field-button" type="button" class="btn btn-primary btn-sm" onclick="add_answer_field()" value="Add answer fields" disabled style="display:none;" />
                    </h2>
                </td>
            </tr>
            </table>
            <form method="post" action="submit_form_layout.php">
            ';} ?>
    <?php
    if(!empty($questions)) {
        foreach ($questions as $key=>$question) {
        echo '
            <table align="center" cellspacing="3" cellpadding="3" width="90%" class="table-hover">
            <tr>
                <td align="left" style="width:90%">
                    <h4><input class="q-select-' . $question['QuestionsID'] . '" type="checkbox" name="checkbox" style="display:none;" value="'.$question['QuestionsID'].'">
                    ' . $question['Question'] . '
                            <a href="edit_question.php?id=' . $question['QuestionsID'] . '" type="button" class="btn btn-warning btn-xs" style="display:none;"> Edit</a>
                            <a href="delete_question.php?id=' . $question['QuestionsID'] . '" type="button" class="btn btn-warning btn-xs" style="display:none;"> Delete</a>
                    </h4>
                </td>
                <td align="left">
                    <button id="edit-answer-field-button-'.$question['QuestionsID'].'" onClick="btn_add('.$question['QuestionsID'].')" type="button" class="btn btn-default" style="display:none;">Edit answer field</button>
                </td>
            </tr></table>';
        echo '<table align="center" cellspacing="3" cellpadding="3" width="90%">
            <tr id="select-wrapper'.$question['QuestionsID'].'" style="display:none;">';
        if($question['AnswerType'] == 1) { //if answerType is Quantitative
        echo '
                <td style="width:30%">
                    <select class="form-control" id="formSelect'.$question['QuestionsID'].'">
                        <option value="radio" selected="selected">Radio Button</option>
                        <option value="checkbox">Check box</option>
                    </select>
                </td>
                <td style="width:15%">
                    <select class="form-control" id="range'.$question['QuestionsID'].'">
                    <option value="2" selected="selected">2 options</option>';
                    for($x=3;$x<=9;$x++) { //loop for 9 options
                        echo '
                        <option value="'.$x.'">'.$x.' options</option>';
                    }
                echo '
                    </select>
                </td>';
        } else if($question['AnswerType'] == 2) { //if answerType is Qualitative
        echo '
                <td style="width:30%">
                    <select class="form-control" id="formSelect'.$question['QuestionsID'].'">
                        <option value="text" selected="selected">Text(single-line)</option>
                        <option value="textarea">Text(multi-line)</option>
                    </select>
                </td>';
        }

        echo '
                <td>
                    <button id="set'.$question['QuestionsID'].'" onClick="set_click(this.id)" type="button" class="btn btn-default">preview</button>
                </td>        ';
        echo '
            </tr>
            <tr>
                <td id="preview-wrapper'.$question['QuestionsID'].'">
                </td>
            </tr>
            </table>
            ';
    }
} else {
    echo '
            <table align="center" cellspacing="3" cellpadding="3" width="90%" class="table-responsive">
            <tr>
                <td align="left"><h4>No questions for this form yet!</h4></td>
            </tr>
            </table>
    ';
}?>
    <input type="hidden" id="fetchcount" value="<?php echo($fetchcount); ?>">
      <input type="submit" value="Save">
        </form>
        </div>
        <script type="text/javascript" src="../js/my-functions.js"></script>
    </body>
</html>