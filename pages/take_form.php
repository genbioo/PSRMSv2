<?php
include ('check_credentials.php');
include ('head.php');
include ('footer.php');
require_once("dbcontroller.php");
include("css_include.php");
include("core_include.php");
$formID = $_SESSION['assessment_tool_ID'];
$idpID = $_SESSION['idpID'];
$idp_name = $_SESSION['idp_name'];
$userID = $_SESSION['userID'];
$db_handle = new DBController();
$form_info = $db_handle->runFetch("SELECT FormID, FormType, Instructions FROM `form` WHERE FormID = ".$formID);
$questions = $db_handle->runFetch("SELECT FORM_FormID, QuestionsID, Question, html_form.HTML_FORM_TYPE as FormType, html_form.HTML_FORM_INPUT_QUANTITY as InputRange FROM form JOIN questions on questions.FORM_FormID = form.FormID JOIN html_form on questions.HTML_FORM_HTML_FORM_ID = html_form.HTML_FORM_ID WHERE form.FormID = ".$formID);
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
                  <div class="panel-heading text-center"><h2><?php if(!empty($form_info)) { foreach ($form_info as $info) { echo($info['FormType']); }} ?></h2></div>
                  <div class="panel-body" style="padding: 20px; 50px;">
                    <h3 style="margin: 10px 40px;">
                        Current IDP: <b><?php echo ($idp_name); ?></b><br>
                    </h3>
                    <h4 style="margin: 20px 40px;"><b>Instructions: </b><?php if(!empty($form_info)) { foreach ($form_info as $info) { echo($info['Instructions']); }} ?></h4>
                    <div style="margin: 30px 40px;" class="header"><h3><b>Questions:</b></h3></div>
                    <form action="submit_answers.php" method="post">
                        <?php
                        if(!empty($questions)) {
                            foreach ($questions as $result) {
                        ?>
                        <table align="center" cellspacing="3" cellpadding="3" width="90%" class=" table-responsive">
                            <tr>
                                <td align="left" style="width:90%" name="no">
                                    <h4>
                                        <?php echo($result['Question']); ?>
                                    </h4>
                                </td>
                            </tr>
                            <tr name="preview-wrapper" style="margin-bottom: 30px;">
                                <td id="preview-wrapper<?php echo($result['QuestionsID']); ?>" >
                                    <?php 
                                        //if $result['FormType'] exists; it means the question is already assigned an html_form
                                        if(isset($result['FormType'])) {
                                            echo '<fieldset id="q-a-'.$result['QuestionsID'].'">';
                                            echo '<input type="hidden" name="q-'.$result['QuestionsID'].'" value="'.$result['QuestionsID'].'">';
                                            if(isset($result['InputRange'])) { //if AnswerRange is not null. It means html form is either checkbox or radio
                                                //html_form inline echo loop
                                                for($i = 0; $i < $result['InputRange']; $i++) {
                                                    echo'<label class="'.$result['FormType'].'-inline"><input type="'.$result['FormType'].'" name="1-'.$result['QuestionsID'].'" value="'.$i.'">'.$i.'</label>';
                                                }
                                            } else {
                                                if($result['FormType'] === "textarea") {
                                                    echo '<textarea class="form-control" rows="5" id="comment" name="2-'.$result['QuestionsID'].'"></textarea>';
                                                } else if($result['FormType'] === "text") {
                                                    echo '<input class="form-control" id="inputdefault" type="'.$result['FormType'].'" name="2-'.$result['QuestionsID'].'">';
                                                }
                                            }
                                            echo '</fieldset>';
                                        }
                                    ?>
                                </td>
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
                        <div class="row">
                            <div class="col-md-12">
                                <button id="btn-submit-form" class="btn btn-primary btn-lg" type="submit"><i class="fa fa-check"></i>&nbsp;Submit</button>
                            </div>   
                        </div>
                    </form>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>