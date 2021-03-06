<?php include ('check_credentials.php'); ?>
<?php include ('head.php'); ?>
        <?php
            include ('footer.php'); 
        ?>
        
        <?php
            require_once("dbcontroller.php");
            include("css_include.php");
            $idpID = $_GET['id'];
            $userID = $_SESSION['userID'];
            $formID;
            $ag = $_GET['ag'];
            if($ag == 1) {
                $formID = 1;
            } else if($ag == 2) {
                $formID = 2;
            }
            $db_handle = new DBController();
            $_SESSION['intake_previous'] = $_SERVER['HTTP_REFERER'];
            $questions = $db_handle->runFetch("SELECT * FROM `questions` WHERE INTAKE_IntakeID = ".$formID);
            $html_forms = $db_handle->runFetch("SELECT * FROM `html_form` WHERE 1");
        
            //Very long query to automatically get the addresses as complete string [instead of fk_ids]
            $idp = $db_handle->runFetch("Select idp.IDP_ID, CONCAT(Lname, ', ', Fname, ' ', Mname) as IDPName, idp.Age, idp.Gender, idp.Education, idp.MaritalStatus, idp.PhoneNum, Origin_Address, EvacTable.EvacName, Evac_Address, EvacTable.EvacType, idp.Email, idp.Occupation, idp.Remarks, idp.SpecificAddress from idp

            JOIN

            evacuation_centers on evacuation_centers.EvacuationCentersID = idp.EvacuationCenters_EvacuationCentersID

            JOIN

            (Select idp.IDP_ID, idp.Origin_Barangay, CONCAT(barangay.BarangayName, ', ', city_mun.City_Mun_Name, ' City, ', province.ProvinceName) as Origin_Address From barangay JOIN city_mun ON city_mun.City_Mun_ID = barangay.City_CityID Join province ON city_mun.PROVINCE_ProvinceID = province.ProvinceID JOIN idp on idp.Origin_Barangay = barangay.BarangayID where barangay.BarangayID = idp.Origin_Barangay)

            AS OriginTable

            ON OriginTable.IDP_ID = idp.IDP_ID

            JOIN

            (Select idp.IDP_ID, idp.EvacuationCenters_EvacuationCentersID, evacuation_centers.EvacType, evacuation_centers.EvacName, evacuation_centers.EvacAddress as EvacAddressID, CONCAT(barangay.BarangayName, ', ', city_mun.City_Mun_Name, ' City, ', province.ProvinceName) as Evac_Address From idp JOIN evacuation_centers ON idp.EvacuationCenters_EvacuationCentersID = evacuation_centers.EvacuationCentersID JOIN barangay ON barangay.BarangayID = evacuation_centers.EvacAddress JOIN city_mun ON city_mun.City_Mun_ID = barangay.City_CityID JOIN province ON city_mun.PROVINCE_ProvinceID = province.ProvinceID where barangay.BarangayID = evacuation_centers.EvacAddress)

            AS EvacTable

            ON EvacTable.IDP_ID = idp.IDP_ID

            WHERE idp.IDP_ID = ".$idpID);
            $education;
        ?>
        <style>
        .container-fluid {
            margin-left: 20%;
            margin-right: 20%;
        }
        .field-label {
            font-size: 15px;
        }
        .sample-output {
            font-size: 10px;
            display: inline-block;
            border-bottom: 1px solid black;
            white-space:pre;
        }
        #idp-info {
            margin-top: 1%;
        }

        .panel-success .panel-heading{
            color: #fff;
            background-color: #5cb85c;
        }

        #btn-submit-intake{
            margin-left: 50px;
            margin-top: 50px;
        }

        #table-intake-questions > tr{
            margin-bottom: 10px;
        }

        #well-intake-form{
            margin-top: 20px;
            background-color: #e0f9e0;
            border: none;
        }

        #well-questions{
            background-color: #fff;
        }
    </style>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-success" style="margin-top: 50px;">
                      <div class="panel-heading text-center"><h2>Intake Form</h2></div>
                      <div class="panel-body" style=" padding: 0 50px;">
                        <?php if(!empty($idp)) {
                                foreach ($idp as $result) {
                                    if($ag === '1') {
                            ?>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- <div class="panel panel-info">
                                  <div class="panel-heading">IDP Information</div>
                                  <div class="panel-body"> -->
                                    <div class="well" id="well-intake-form">
                                    <div class="header"><h3><b>IDP Information</b></h3></div>
                                    <hr>
                                    <div id="idp-info">
                                        <p class="field-label"><b>Date of Intake: </b><?php echo(date("l").', '.date("m-d-Y")); ?></p>
                                        <p class="field-label"><b>Name: </b><?php echo($result['IDPName']); ?></p>
                                        <p class="field-label"><b>Age: </b><?php echo($result['Age']); ?></p>
                                        <p class="field-label"><b>Sex: </b><?php echo(($result['Gender'] == 1) ? 'Male' : 'Female'); ?></p>
                                        <p class="field-label"><b>Marital status: </b><?php echo(($result['MaritalStatus'] == 1) ? 'Single' : 'Married'); ?></p>
                                        <?php
                                        if(isset($result['Occupation'])) {
                                            echo '<p class="field-label"><b>Employment/ Occupation: </b>'.$result['Occupation'].'</p>';
                                        }
                                        ?>
                                        <p class="field-label"><b>Type of Relocation: </b><?php echo(($result['EvacType'] == 1) ? 'Government' : 'Home-based'); ?></p>
                                        <p class="field-label"><b>Address/Name of Evacuation Center: </b><?php echo($result['EvacName'].'; '.$result['Evac_Address']); ?></p>
                                            <?php
                                                echo '<p class="field-label"><b>Address prior to evacuation: </b>';
                                                if(isset($result['SpecificAddress'])) {
                                                    echo($result['SpecificAddress'].'; ');
                                                }
                                                echo($result['Origin_Address']);
                                                echo '</p>';
                                            ?>
                                        <p class="field-label"><b>Contact info: </b></p>
                                    </div>
                                    </div>
                                  <!-- </div>
                                </div> -->
                                <?php } else if($ag === '2') { ?> 
                                <!-- <div class="panel panel-info">
                                  <div class="panel-heading">IDP Information</div>
                                  <div class="panel-body"> -->
                                  <div class="well" id="well-intake-form">
                                  <div class="header"><h3><b>IDP Information</b></h3></div>
                                  <hr>
                                    <div id="idp-info">
                                         <p class="field-label"><b>Date of Intake: </b><?php echo(date("l").', '.date("m-d-Y")); ?></p>
                                        <p class="field-label"><b>Name: </b><?php echo($result['IDPName']); ?></p>
                                        <p class="field-label"><b>Age: </b><?php echo($result['Age']); ?></p>
                                        <p class="field-label"><b>Sex: </b><?php echo(($result['Gender'] == 1) ? 'Male' : 'Female'); ?></p>
                                        <?php
                                            if(isset($result['Education'])) {
                                                echo('<p class="field-label"><b>Education: </b>'.$result['Education'].'</p>');
                                            }
                                            /*if(isset($result['Education'])) {
                                                echo('<p class="field-label"><b>Name of school: </b></p>');
                                            }*/
                                        ?>
                                        <p class="field-label"><b>Name of mother: </b></p>
                                        <p class="field-label"><b>Name of father: </b></p>
                                        <p class="field-label"><b>Type of Relocation: </b><?php echo(($result['EvacType'] == 1) ? 'Government' : 'Home-based'); ?></p>
                                        <p class="field-label"><b>Address/Name of Evacuation Center: </b><?php echo($result['EvacName'].'; '.$result['Evac_Address']); ?></p>
                                        <p class="field-label"><b>Address prior to evacuation: </b>
                                            <?php
                                                if(isset($result['SpecificAddress'])) {
                                                    echo($result['SpecificAddress'].'; ');
                                                }
                                                echo($result['Origin_Address']);
                                            ?>
                                        </p>
                                        <p class="field-label"><b>Contact info: </b></p>
                                    </div>
                                    </div>
                                  <!-- </div>
                                </div> -->
                                 <?php
                                        } 
                                    
                                    }
                                }
                                ?>

                                <!-- <div class="panel panel-primary">
                                  <div class="panel-body"> -->
                                    <div class="well" id="well-questions">
                                    <div class="header"><h3><b>Questions</b></h3></div>
                                    <form action="submit_intake_answers.php?id=<?php echo($idpID); ?>&ag=<?php echo($ag); ?>" method="post">
                                        <?php
                                        if(!empty($questions)) {
                                            foreach ($questions as $question) {
                                        ?>
                                        <table id="table-intake-questions" align="center" cellspacing="3" cellpadding="3" width="90%" class="table-responsive table-striped">
                                            
                                            <tr>
                                                <td name="no">
                                                    <h4>
                                                        <?php echo($question['Question']); ?>
                                                    </h4>
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
                                                            echo '<fieldset id="q-a-'.$question['QuestionsID'].'">';
                                                            $formRange = $outputArray[0][2];
                                                            $formType = $outputArray[0][1];
                                                            if($outputArray[0][2] !== null) { //if formRange is not null. It means html form is either checkbox or radio
                                                                //html_form inline echo loop
                                                                for($i = 0; $i < $formRange; $i++) {
                                                                    echo'<label class="'.$formType.'-inline"><input type="'.$formType.'" name="'.$question['AnswerType'].'-'.$question['QuestionsID'].'" value="'.$i.'">'.$i.'</label>';
                                                                }

                                                            } else {
                                                                if($formType === "textarea") {
                                                                    echo '<textarea class="form-control" rows="5" id="comment" name="'.$question['AnswerType'].'-'.$question['QuestionsID'].'"></textarea>';
                                                                } else if($formType === "text") {
                                                                    echo '<input class="form-control" id="inputdefault" type="'.$formType.'" name="'.$question['AnswerType'].'-'.$question['QuestionsID'].'">';
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
                                                <button id="btn-submit-intake" class="btn btn-primary btn-lg" type="submit"><i class="fa fa-check"></i>&nbsp;Submit</button>
                                            </div>   
                                        </div>
                                    </form>
                                    </div>
                                  <!-- </div>
                                </div>  -->

                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-12">
                               
                            </div>
                        </div> -->
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <script type="text/javascript" src="../js/validate-input.js"></script>