
<?php session_start(); include ('head.php'); ?>
 <?php 
            //include("css_include.php");
            include("core_include.php");
            $prev = $_SERVER['HTTP_REFERER'];
            require_once("dbcontroller.php");

            if(!isset($_SESSION['form_id'])&& !isset($_SESSION['form_name']))
            {
                $_SESSION['form_id'] = $_GET['form_id'];
                $_SESSION['form_name'] = $_GET['form_name'];
            }
       

            $form_id =  $_SESSION['form_id'];
            $form_name =  $_SESSION['form_name'];
            $db_handle = new DBController();
            $questions = $db_handle->runFetch("SELECT * FROM `questions` WHERE FORM_FormID = ".$form_id.";");
            $instructions = $db_handle->runFetch("SELECT * FROM `form` WHERE FormID = ".$form_id);



        ?>
        <?php //class="table-striped table-bordered table-hover" ?>
        





<?php include ('sidebar.php'); ?>

    <div class="main-panel">
        
<?php include ('navbar.php'); ?>

  <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                  <h4 class="title"><?php echo 'Form Name: <b>'.($form_name).'</b>'; ?></h4>



                                <p class="category">Instructions: <?php if(!empty($instructions)) { foreach ($instructions as $instruction) { echo $instruction['Instructions'];}} ?></p>
                            </div>

                             <div class="content">
                                <div id="formsPreferences" class="ct-forms ct-perfect-fourth">
            <table align="left" cellspacing="3" cellpadding="3" width="75%" class="table-striped table-hover">
           
         
            <tr>
                <?php if ($db_handle->getFetchCount() == 1) {
                    echo '<td align="left"><h2>Question &nbsp;<a href="add_question.php?id='.$form_id.'" class="btn btn-info btn-sm" role="button">add question</a></h2></td>';
                } else {
                     echo '<td align="left">
                        <h5><b>
                       <input type="checkbox" onClick="toggle(this)" name="toggleCheckbox" style="display:none;"/>Questions &nbsp;
                       </td>
                       <td align="left">
                       <a href="add_question.php?form_id='.$form_id.'" class="btn btn-info btn-sm" role="button">add question</a> &nbsp;
                    <button id="edit-questions-button" onClick="show_edit_interface()" type="button" class="btn btn-default btn-sm">Edit questions</button>
                    <input id="add-answer-field-button" type="button" class="btn btn-primary btn-sm" onclick="add_answer_field()" value="Add answer fields" disabled style="display:none;" /></b></h5></td>
                    <form method="post" action="">';} ?>
    <?php
    if(!empty($questions)) {
        foreach ($questions as $key=>$question) {
        echo '
        
            <tr>
                <td align="left" >
                    <h4><input class="q-select-' . $question['QuestionsID'] . '" type="checkbox" name="checkbox" style="display:none;" value="'.$question['QuestionsID'].'">
                    ' . $question['Question'] . '
                            <a href="edit_question.php?id=' . $question['QuestionsID'] . '" type="button" class="btn btn-warning btn-xs" style="display:none;"> Edit</a>
                            <a href="delete_question.php?id=' . $question['QuestionsID'] . '" type="button" class="btn btn-warning btn-xs" style="display:none;"> Delete</a>
                    </h4>
                </td>';
                if(  $question['HTML_FORM_HTML_FORM_ID'] ==0 || $question['HTML_FORM_HTML_FORM_ID'] == 'NULL'){
                       
                        echo '
                            <td align="left">
                                <button name ="answer_field" id="'. $question['QuestionsID'] .'" onClick="btns_add(this.id)" type="button" class="btn btn-default">Add answer field</button>
                                ';}
                                else {

                                 
                                      $html_forms = $db_handle->runFetch("SELECT * FROM `html_form` WHERE HTML_FORM_ID = ".$question['HTML_FORM_HTML_FORM_ID'].";"); 


                                        if(!empty($html_forms)) {

                                        foreach ($html_forms as $html_form) {
                                            //echo $html_form['HTML_FORM_ID'];
                                            echo '<td id = "'.$question['QuestionsID'].'" align="left">';
                                        for($count =1; $count<= $html_form['HTML_FORM_INPUT_QUANTITY']; $count++){
                                               echo 
                                                '<label class="radio-inline"> <input  type='.$html_form['HTML_FORM_TYPE'].' >' .$count. '</label>'; 
                                        }}}
                                                echo 
                                                    '<sup>
                                                        <button id="'.$question['QuestionsID'].'" onClick="btns_add(this.id)" type="button" class="btn btn-default"> Edit</button> 
                                                    </sup>
                                                
                                                </td> </tr>';
                                        }
            
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
                    <button id="set'.$question['QuestionsID'].'" onClick="sets_click(this.id)" type="button" class="btn btn-default">preview</button>
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
      <input type="submit" onClick="get_input()" value="Save"  class="btn btn-default">
        </form>
        </div>
        <script type="text/javascript" src="../js/my-functions.js"></script>
    </body>
</html>