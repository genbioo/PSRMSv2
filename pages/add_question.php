<html>
    <head>
        <?php
        require('check_credentials.php');
        include("css_include.php");
        include("core_include.php");
        require_once("dbcontroller.php");
        $id = $_GET['id'];
        $type = $_GET['type'];
        $db_handle = new DBController();
        $forms = $db_handle->runFetch("SELECT * FROM `form` WHERE FormID = '".$id."'");
        $_SESSION['previous'] = $_SERVER['HTTP_REFERER'];
        ?>
    </head>
    <body>
        <div class="container">
            <div>
                <a href="dashboard.php">Home</a>
            </div>
            <div class="row-sm-12">
                <h2>Add Question</h2>
            </div>
            <div class="row-sm-12">
                <p>This section is for adding a new question to an existing form. This question will be added to form: <b><?php
                    if(!empty($forms)) {
                        foreach ($forms as $form) {
                            echo ($form['FormType']);
                        }
                    }?></b>
                </p>
            </div>
            <div>
                <form action="<?php echo('submit_add_question.php?type='.$type) ?>" method="post" onsubmit="return check_empty()">
                    <div>
                        <div id="question-field-container-0">
                            <div class="form-group">
                            <label><br>Question:</label>
                            <textarea class="form-control" rows="5" name="question_add0"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="radio-inline"><input type="radio" name="answerType0" value="1">Quantitative</label>
                                <label class="radio-inline"><input type="radio" name="answerType0" value="2">Qualitative</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="hidden" name="formID" value="<?php echo($id); ?>">
                        <button type="button" class="btn btn-info" onclick="add_more_questions()">Add more</button>
                        <input type="submit" class="btn btn-info" value="Submit">
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        var i = 0;
        function add_more_questions() {
            // get the last DIV which ID starts with ^= "klon"
            var $div = $('div[id^="question-field-container-"]:last');

            // Read the Number from that DIV's ID (i.e: 3 from "klon3")
            // And increment that number by 1
            var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;

            // Clone it and assign the new ID (i.e: from num 4 to ID "klon4")
            var $klon = $div.clone().prop('id', 'question-field-container-'+num );
            
            //edit names of the html forms to avoid conflict in $_POST
            //for textbox
            $($klon.find("[name='question_add"+(num-1)+"']")).attr("name","question_add"+num);
            //for radio buttons
            //two results in $klon.find("[name='answerType"+(num-1)+"']") hence the [0] index
            $($klon.find("[name='answerType"+(num-1)+"']")[0]).attr("name","answerType"+num);
            //index is still 0 because the previous name is already changed
            $($klon.find("[name='answerType"+(num-1)+"']")[0]).attr("name","answerType"+num);
            // Finally insert $klon wherever you want
            $div.after( $klon );
        }
            
        function check_empty() {
            var flag_radio = true;
            var flag_textarea = true;
            
            //check if a radio button is unticked
            $('input:radio').each(function () {
                name = $(this).attr('name');
                if (flag_radio && !$(':radio[name="' + name + '"]:checked').length) {
                    flag_radio = false;
                }
            });
            
            //check if a textarea is empty
            $('textarea').each(function() {
              if (!$.trim($(this).val())) {
                 flag_textarea = false; 
              }
            });
            
            //if nothing is empty
            if(flag_radio && flag_textarea) {
                return true;
            } else {
                alert("Please do not leave any field empty before submitting.");
                return false;
            }
        }
        </script>
    </body>
</html>