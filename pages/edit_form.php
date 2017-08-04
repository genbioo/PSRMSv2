<?php include ('check_credentials.php'); ?>
<?php require_once("dbcontroller.php"); ?>
<?php $ul_index = "active"; $ul_forms = ""; $ul_idp =""; include ('sidebar.php'); ?>
<?php include ('head.php'); ?>
<?php
        $id = $_GET['form_id'];
        $name = $_GET['form_name'];
        $db_handle = new DBController();
        $questions = $db_handle->runFetch("SELECT * FROM `questions` WHERE FORM_FormID = ".$id);
        $form_info = $db_handle->runFetch("SELECT * FROM `form` WHERE FormID = ".$id);
        $html_forms = $db_handle->runFetch("SELECT * FROM `html_form` WHERE 1");
        $q_has_null_form = false; //will check later if a question has null html_form
        $qid_array = array(); //array to store questions ids
        $formRange = ""; //will store current question form range
        $formType = "";  //will store current question form type
        foreach($questions as $question) {
            if(array_key_exists('HTML_FORM_HTML_FORM_ID', $question) && is_null($question['HTML_FORM_HTML_FORM_ID'])) {
                $q_has_null_form = true;
            }
        }
        
        //class="table-striped table-bordered table-hover"
        //class="table-hover table-responsive"
        ?>
        




<?php  include ('modal.php'); 
?>

    <div class="main-panel">
        
<?php include ('navbar.php'); ?>


<div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4><b>Form Title: </b><?php if(!empty($form_info)) { foreach ($form_info as $info) { echo($info['FormType']); }} ?>
                                <a href="#" type="button" class="btn btn-warning btn-fill btn-xs"> Edit</a></h4>
                                
                                <h5><b>Instructions: </b><?php if(!empty($form_info)) { foreach ($form_info as $info) { echo($info['Instructions']); }} ?>
                                <a href="#" type="button" class="btn btn-warning btn-fill btn-xs"> Edit</a></h5>
                            </div>
                            <div class="content">
                                <div id="formsPreferences" class="ct-forms ct-perfect-fourth">

           <div class="form-group">
            <table align="center" cellspacing="3" cellpadding="3" width="90%" class="table-responsive">
            
            <?php
                //just checking whether to display 'Question' or 'Questions': I apologize for including this trivial matter :)
                if ($db_handle->getFetchCount() === 1) { ?>
                <tr>
                    <td align="left">
                        <h2>Question &nbsp;<a href="add_question.php?type=assessment&id=<?php echo($id); ?>" class="btn btn-success btn-fill btn-sm" role="button">add question</a></h2>
                    </td>
            <?php } else { ?>
                <tr>
                
                    <td align="left">
                        <h2>
                            <input style="display:none; margin-top: 15px;" id="toggle" type="checkbox" onClick="toggle(this)" name="toggleCheckbox" style="display:none;"/>Questions &nbsp;<a href="add_question.php?type=assessment&id=<?php echo($id); ?>" class="btn btn-success btn-fill btn-sm" role="button">add question</a>
                            
            <?php
                         }
                if(!$q_has_null_form ) { ?>
                            
                            <input id="preview-form-button" onClick="preview_form(this)" type="button" class="btn btn-primary btn-fill btn-sm" value="hide preview">
                            
                            <?php } ?>
                            
                            <?php if($q_has_null_form ) { ?>

                            <input id="edit-questions-button" onClick="show_edit_interface()" type="button" class="btn btn-primary btn-fill btn-sm" value="Attach answer fields to new question(s)">

                            <input id="add-answer-field-button" type="button" class="btn btn-primary btn-fill btn-sm" data-toggle="modal" data-target="#add_answer_fields_modal" onclick="show_modal()" disabled style="display:none;" value="Select question(s) first...">
                            
                            <?php } else { ?>
                            
                            <input id="edit-questions-button" onclick="show_modal()" type="button" class="btn btn-warning btn-fill btn-sm" value="Edit all question answer fields" data-toggle="modal" data-target="#add_answer_fields_modal">
                            
                            <?php } ?>
                        </h2>
                    </td>
                    
                </tr>
            </table>
            
            <form id="form-layout" action="submit_form_layout.php" onsubmit="return validate_forms()" method="post">
                
            <?php
            if(!empty($questions)) {
                foreach ($questions as $question) {
                //store qid to array
                array_push($qid_array, $question['QuestionsID']);
            ?>
                
            <table align="center" cellspacing="3" cellpadding="3" width="90%" class="table-hover table-responsive">
                <tr>
                
                    <td align="left" style="width:90%" name="no">
                        <p style="margin-bottom: 20px; margin-top: 20px;">
                        <input class="q-select-<?php echo($question['QuestionsID']); ?>" type="checkbox" name="checkbox" onchange="toggle(this)" style="display:none;" value="<?php echo($question['QuestionsID']); ?>" <?php if(!$q_has_null_form ) { echo('checked="checked"');} ?> >
                        <input id="<?php echo($question['QuestionsID']); ?>-ans-type" type="hidden" value="<?php echo($question['AnswerType']); ?>">
                            <?php echo($question['Question']); ?>
                        </p>
                    </td>
                    
                    <td align="left">
                        <input id="edit-answer-field-button-<?php echo($question['QuestionsID']); ?>" onClick="edit_ansf(<?php echo($question['QuestionsID']); ?>)" type="button" class="btn btn-warning btn-fill btn-xs" <?php echo isset($question['HTML_FORM_HTML_FORM_ID']) ? '' : 'style="display:none;"'; ?> value="Edit answer field">
                    </td>
                    <td>
                        <a href="edit_question.php?id=<?php echo($question['QuestionsID']); ?>" type="button" class="btn btn-warning btn-fill btn-xs"> Edit</a>
                    </td>
                    <td>
                        <a href="delete_question.php?id=<?php echo($question['QuestionsID']); ?>" type="button" class="btn btn-warning btn-fill btn-xs"> Delete</a>
                    </td>
                    
                </tr>
                <tr name="preview-wrapper">
                    <td id="preview-wrapper<?php echo($question['QuestionsID']); ?>">
                        <?php 
                            $outputArray = array();
                            //if $question['HTML_FORM_HTML_FORM_ID'] exists, create these elements
                            if(isset($question['HTML_FORM_HTML_FORM_ID'])) {
                                $array_iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($html_forms));
                                //find html form row corresponding with $question['HTML_FORM_HTML_FORM_ID']
                                foreach ($array_iterator as $sub) {
                                    $subArray = $array_iterator->getSubIterator();
                                        if ($subArray['HTML_FORM_ID'] === $question['HTML_FORM_HTML_FORM_ID']) {
                                        $outputArray[] = array_values(iterator_to_array($subArray));
                                    }
                                }
                                $qid_form_range[] = $outputArray[0]; //will be used for setting default dropdown values in 
                                echo '<form>';
                                $formRange = $outputArray[0][2];
                                $formType = $outputArray[0][1];
                                if($outputArray[0][2] !== null) { //if formRange is not null. It means html form is either checkbox or radio
                                    //html_form inline echo loop
                                    for($i = 0; $i < $formRange; $i++) {
                                        echo'<label class="'.$formType.'-inline"><input type="'.$formType.'" name="opt-'.$formType.'">'.$i.'</label>';
                                    }

                                } else {
                                    if($formType === "textarea") {
                                        echo '<textarea class="form-control" rows="5" id="comment"></textarea>';
                                    } else if($formType === "text") {
                                        echo '<input class="form-control" id="inputdefault" type="'.$formType.'">';
                                    }
                                }
                                echo '</form>';
                            }
                        ?>
                    </td>
                </tr>
            </table>
            <table align="center" cellspacing="3" cellpadding="3" width="90%">
                <tr id="select-wrapper<?php echo($question['QuestionsID']); ?>" style="display:none;">
            <?php
                    if($question['AnswerType'] == 1) { //if answerType is Quantitative
                    ?>
                    <td style="width:30%">
                        <select class="form-control" id="formSelect<?php echo($question['QuestionsID']); ?>" name="formSelect<?php echo($question['QuestionsID']); ?>">
                            <option value="radio" <?php echo($formType === "radio" ? 'selected="selected"' : '' ); ?> >Radio Button</option>
                            <option value="checkbox" <?php echo($formType === "checkbox" ? 'selected="selected"' : '' ); ?> >Check box</option>
                        </select>
                    </td>
                    <td style="width:15%">
                        <select class="form-control" id="range<?php echo($question['QuestionsID']); ?>" name="range<?php echo($question['QuestionsID']); ?>">
                        <?php
                        for($x=2;$x<=9;$x++) { //loop for 9 options
                            echo '
                            <option value="'.$x.'" ';
                            if($x == $formRange) echo 'selected';
                            echo'>'.$x.' options</option>';
                        }
                        ?>
                        </select>
                    </td>
                    <td>
                        <button id="set<?php echo($question['QuestionsID']); ?>" onClick="display_form(this.id, 1, 'single')" type="button" class="btn btn-primary btn-fill">preview</button>
                    </td>
            <?php
                    } else if($question['AnswerType'] == 2) { //if answerType is Qualitative
            ?>
                    <td style="width:30%">
                        <select class="form-control" id="formSelect<?php echo($question['QuestionsID']); ?>" name="formSelect<?php echo($question['QuestionsID']); ?>">
                            <option value="text" <?php echo($formType === "text" ? 'selected="selected"' : '') ?> >Text(single-line)</option>
                            <option value="textarea" <?php echo($formType === "textarea" ? 'selected="selected"' : '' ); ?> >Text(multi-line)</option>
                        </select>
                    </td>
                    <td style="width:15%">
                        <select class="form-control" id="range<?php echo($question['QuestionsID']); ?>" name="range<?php echo($question['QuestionsID']); ?>" style="display:none;">
                            <option value="null" selected="selected"></option>
                        </select>
                    </td>
                    <td>
                        <button id="set<?php echo($question['QuestionsID']); ?>" onClick="display_form(this.id, 2, 'single')" type="button" class="btn btn-primary btn-fill">preview</button>
                    </td>
            <?php 
                    }
            ?>
                </tr>
            </table>
            <?php
                }
            } else { ?>
            <table align="center" cellspacing="3" cellpadding="3" width="90%" class="table-responsive">
                <tr>
                    
                    <td align="left">
                        <h4>No questions for this form yet!</h4>
                    </td>
                    
                </tr>
            </table>
            <?php
            }
            ?>
            <button class="btn btn-primary btn-fill btn-lg" style="margin-left: 50px; margin-top: 50px;"><i class="fa fa-save"></i>&nbsp;Save Layout</button>
            </form>
        </div>
                    
        <!-- Modal for add answer fields -->
        
<div id="myModal" class="modal">
          <div class="modal-dialog">

            <!-- Modal content -->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" onclick="modal_close()" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Please select HTML form to display.</h4>
              </div>
              <div class="modal-body" id="modal-dropdown-content" >
                <p>Some text in the modal.</p>
              </div>
              <div class="modal-footer">
                <input  type="button" class="btn btn-primary btn-fill btn-sm" onclick="add_answer_field()" value="Add and preview" data-dismiss="modal" />
                <input  type="button" class="btn btn-primary btn-fill btn-sm" onclick="add_and_save()" value="Add and save" data-dismiss="modal" />
              </div>
            </div>
            <!-- content end -->

          </div>
        </div>

       <!-- <div id="myModal" class="modal">
          
          <div class="modal-content">
            <div class="modal-header" style="height: 50px;">
            <h4 class="modal-title">Add Question</h4>
            </div>
            <div class="modal-body" style="margin-bottom: 20px;"> 
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
                                <?php ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button class="btn btn-info btn-md" type="submit"><i class="fa fa-check"></i>Submit</button>
                        </td>
                    </tr>
                    </form>
              </div>
            </div>
          </div> -->

            
          </div>
    </div>
</div>

<?php include('footer.php'); ?>
<?php
    $_SESSION['q_ids'] = $qid_array; //save qid array to session
?>
