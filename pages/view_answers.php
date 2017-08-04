<?php
    include ('check_credentials.php');
    include ('head.php');
    include ('footer.php');
    require_once("dbcontroller.php");
    include("css_include.php");
    include("core_include.php");
    $form_answersID = $_GET['id'];
    $db_handle = new DBController();
    $resultInfo = $db_handle->runFetch("SELECT FORM_ANSWERS_ID, form.FormType, form.Instructions, CONCAT(idp.Lname,', ',idp.Fname,' ',idp.Mname) as IDPName, CONCAT(user.Lname,', ', user.Fname, ' ', user.Mname) as UserResponsible, form_answers.UnansweredItems, form_answers.DateTaken FROM form_answers JOIN idp on IDP_IDP_ID = idp.IDP_ID JOIN user on form_answers.USER_UserID = user.UserID JOIN form on form.FormID = form_answers.FORM_FormID WHERE form_answers.FORM_ANSWERS_ID = ".$form_answersID);
    $resultItems = $db_handle->runFetch("SELECT form_answers.FORM_ANSWERS_ID, questions.QuestionsID, questions.Question, html_form.HTML_FORM_TYPE AS FormType, html_form.HTML_FORM_INPUT_QUANTITY AS AnswerRange, answers_quanti.ANSWERS_QUANTI_ID as AnswerID, answers_quanti.Answer FROM form_answers JOIN questions ON form_answers.FORM_FormID = questions.FORM_FormID JOIN html_form on questions.HTML_FORM_HTML_FORM_ID = html_form.HTML_FORM_ID LEFT JOIN answers_quanti ON answers_quanti.FORM_ANWERS_FORM_ANSWERS_ID = form_answers.FORM_ANSWERS_ID && answers_quanti.QUESTIONS_QuestionsID = questions.QuestionsID WHERE form_answers.FORM_ANSWERS_ID = ".$form_answersID);
?>
<style>
    .container-fluid {
        margin-left: 20%;
        margin-right: 20%;
    }

    #btn-submit-form{
        margin-left: 40px;
        margin-top: 50px;
    }
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" style="margin-top: 50px;">
                  <div class="panel-heading text-center"><h2><?php if(!empty($resultInfo)) { foreach ($resultInfo as $info) { echo($info['FormType']); }} ?></h2></div>
                  <div class="panel-body" style="padding: 20px; 50px;">
                    <h3 style="margin: 10px 40px;">
                        Current IDP: <b><?php echo ($info['IDPName']); ?></b><br>
                    </h3>
                    <h4 style="margin: 20px 40px;"><b>Instructions: </b><?php echo($info['Instructions']); ?></h4>
                    <div style="margin: 30px 40px;" class="header"><h3><b>Questions:</b></h3></div>
                    <form action="update_answers.php?id=<?php echo($form_answersID); ?>" method="post">
                        <?php
                        if(!empty($resultItems)) {
                            foreach ($resultItems as $result) {
                        ?>
                        <table align="center" cellspacing="3" cellpadding="3" width="90%" class=" table-responsive">
                            <?php
                                if(isset($result['Answer'])) {
                                    echo '<tr>';
                                } else {
                                    echo '<tr class="bg-warning">';
                                }
                            ?>
                                <td align="left" style="width:90%" name="no">
                                    <h4>
                                        <?php echo($result['Question']); ?>
                                    </h4>
                                </td>   
                            <?php echo '</tr>' ?>
                            <?php
                                if(isset($result['Answer'])) {
                                    echo '<tr name="preview-wrapper" style="margin-bottom: 30px;">';
                                } else {
                                    echo '<tr name="preview-wrapper" style="margin-bottom: 30px;" class="bg-warning">';
                                }
                            ?>
                                <td id="preview-wrapper<?php echo($result['QuestionsID']); ?>" >
                                    <?php 
                                        //if $result['HTML_FORM_HTML_FORM_ID'] exists, create these elements
                                        if(isset($result['FormType'])) {
                                            echo '<fieldset id="q-a-'.$result['QuestionsID'].'">';
                                            echo '<input type="hidden" name="q-'.$result['QuestionsID'].'" value="'.$result['QuestionsID'].'">';
                                            if(isset($result['AnswerRange'])) { //if AnswerRange is not null. It means html form is either checkbox or radio
                                                if(isset($result['Answer'])) {
                                                    for($i = 0; $i < $result['AnswerRange']; $i++) {
                                                        if($i == $result['Answer']) {
                                                            echo'<label class="'.$result['FormType'].'-inline"><input type="'.$result['FormType'].'" name="1-'.$result['QuestionsID'].'" value="'.$i.'" checked="checked" disabled="disabled">'.$i.'</label>';
                                                        } else {
                                                            echo'<label class="'.$result['FormType'].'-inline"><input type="'.$result['FormType'].'" name="1-'.$result['QuestionsID'].'" value="'.$i.'" disabled="disabled">'.$i.'</label>';
                                                        }
                                                    }
                                                
                                                } else {
                                                    //html_form inline echo loop
                                                    for($i = 0; $i < $result['AnswerRange']; $i++) {
                                                        echo'<label class="'.$result['FormType'].'-inline"><input type="'.$result['FormType'].'" name="1-'.$result['QuestionsID'].'" value="'.$i.'">'.$i.'</label>';
                                                    }
                                                }
                                            } else {
                                                if($result['FormType'] === "textarea") {
                                                    if(isset($result['Answer'])) {
                                                        echo '<textarea class="form-control" rows="5" id="comment" name="2-'.$result['QuestionsID'].'" disabled="disabled">'.$result['Answer'].'</textarea>';
                                                    } else {
                                                        echo '<textarea class="form-control" rows="5" id="comment" name="2-'.$result['QuestionsID'].'"></textarea>';
                                                    }
                                                } else if($result['FormType'] == "text") {
                                                    if(isset($result['Answer'])) {
                                                        echo '<input class="form-control" id="inputdefault" type="'.$result['FormType'].'" name="2-'.$result['QuestionsID'].'" value="'.$result['Answer'].'">';
                                                    } else {
                                                        echo '<input class="form-control" id="inputdefault" type="'.$result['FormType'].'" name="2-'.$result['QuestionsID'].'">';
                                                    }
                                                }
                                            }
                                            echo '</fieldset>';
                                        }
                                    ?>
                                </td>
                            <?php echo '</tr>' ?>
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
                        <div class="row">
                            <div class="col-md-12">
                                <button id="btn-submit-form" class="btn btn-primary btn-lg" type="submit"><i class="fa fa-check"></i>&nbsp;Update</button>
                            </div>   
                        </div>
                    </form>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>