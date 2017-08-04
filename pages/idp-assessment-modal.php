 <?php
require_once("dbcontroller.php");
$db_handle = new DBController();
$idp_id = $_GET['id'];

$idps = $db_handle->runFetch("SELECT * FROM `idp` WHERE idp.IDP_ID = ".$idp_id);
if(!empty($idps)) {
    foreach ($idps as $idp) {
?> 

<tr>
    <td>
        <!-- The Modal -->
        <div id="myModal<?php echo($idp['IDP_ID']) ?>" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="carousel-inner"> <!-- carousel container -->
                    <div class="item active"> <!-- IDP details container -->
                        <div class="modal-header">
                            <span id = "<?php echo($idp['IDP_ID']) ?>" class="close" onclick="close_modal(this.id)">&times;</span>
                            <h2>
                                <?php echo($idp['Fname']) ?>&nbsp;<?php echo($idp['Mname']) ?>&nbsp;<?php echo($idp['Lname']) ?>
                                <span><h5><sup>Personal Information</sup></h5></span>
                            </h2>

                        </div>
                        <div class="modal-body">
                    <?php
                    $id = $idp['IDP_ID'];

                    $unique_idps = $db_handle->runFetch("SELECT * FROM idp WHERE IDP_ID =$id");

                    $idp_sectors = $db_handle->runFetch("SELECT * FROM idp_sector WHERE IDP_IDP_ID = $id");

                    $dafac_nos = $db_handle->runFetch("SELECT * FROM dafac_no WHERE DAFAC_SN = $id");

                    $query2 = $db_handle->runFetch("SELECT * FROM idp, city_mun,province,barangay WHERE IDP_ID = $id AND Origin_Barangay=BarangayID AND City_Mun_ID = City_CityID AND PROVINCE_ProvinceID=ProvinceID");

                        if(!empty($unique_idps)) {
                            foreach ($unique_idps as $result1) {
                    ?>

                            <h4> Personal Information <hr></h4>
                            <table align="left" cellspacing="3" cellpadding="3" width="75%" class="table  "  style="border-top: 0px solid black !important">
                                <tr style="border-top: 0px solid black" >
                                    <td style="border-top: 0px solid black"><h5><b>Birthdate</b></h5></td>
                                    <td style="border-top: 0px solid black"><h5><b>Age</b></h5></td>
                                    <td style="border-top: 0px solid black"><h5><b>Gender</b></h5></td>
                                    <td style="border-top: 0px solid black"><h5><b>Marital Status</b></h5></td>
                                    <td style="border-top: 0px solid black"><h5><b>Relation to Head</b></h5></td>

                                </tr>
                                <tr>
                                    <td style="border-top: 0px solid black"><?php echo $result1['Bdate']; ?></td>
                                    <td style="border-top: 0px solid black"><?php echo $result1['Age']; ?></td>
                                    <td style="border-top: 0px solid black"><?php echo ($result1['Gender'] == '1') ? 'Male' : 'Female'; ?></td>
                                <?php

                                $maritalStatus = $result1['MaritalStatus'];
                                if ($maritalStatus == "1"){
                                    $maritalStatus = "Single";
                                } else if($maritalStatus == "2"){
                                    $maritalStatus = "Married";
                                } else if($maritalStatus == "3"){
                                    $maritalStatus = "Annulled";
                                } else if($maritalStatus == "4"){
                                    $maritalStatus = "Widowed";
                                }
                                ?>
                                    <td style="border-top: 0px solid black"><?php echo $maritalStatus ?></td>
                                    <td style="border-top: 0px solid black"><?php echo $result1['RelationToHead']; ?></td>
                                </tr>
                            </table>

                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>

                            <h4>Original Address <hr></h4>
                            <table align="left" cellspacing="3" cellpadding="3" width="75%" class="table">
                                <tr>
                                    <td style="border-top: 0px solid black"><h5><b>Street/Purok</b></h5></td>
                                    <td style="border-top: 0px solid black"><h5><b>Barangay</b></h5></td>
                                    <td style="border-top: 0px solid black"><h5><b>City/Municipality</b></h5></td>
                                    <td style="border-top: 0px solid black"><h5><b>District</b></h5></td>
                                    <td style="border-top: 0px solid black"><h5><b>Province</b></h5></td>
                                </tr>
                                <tr>
                                    <td style="border-top: 0px solid black"></td>
                                    <td style="border-top: 0px solid black">
                            <?php
                            $b_id =$result1['Origin_Barangay'];
                            $barangays = $db_handle->runFetch("SELECT * FROM barangay WHERE BarangayID = $b_id");
                            foreach ($barangays as $barangay) {
                                $c_id =$barangay['City_CityID'];
                                echo $barangay['BarangayName'];
                            }
                            ?>
                                    </td>
                                    <td style="border-top: 0px solid black">
                            <?php
                            $citys = $db_handle->runFetch("SELECT * FROM city_mun WHERE City_Mun_ID = $c_id");
                            foreach ($citys as $city) {
                                $p_id = $city['PROVINCE_ProvinceID'];
                                echo $city['City_Mun_Name'];
                            }
                            ?>
                                    </td>
                                    <td style="border-top: 0px solid black"></td>
                                    <td style="border-top: 0px solid black">
                            <?php
                            $provinces = $db_handle->runFetch("SELECT * FROM province WHERE ProvinceID = $p_id");
                            foreach ($provinces as $province) {
                                echo $province['ProvinceName'];
                            }
                            ?>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <h4>Education and Work <hr></h4> 
                            <table align="left" cellspacing="3" cellpadding="3" width="75%" class="table ">
                                <tr>
                                    <td style="border-top: 0px solid black"><h5><b>Educational Attainment</b></h5></td>
                                    <td style="border-top: 0px solid black"><h5><b>Employment</b></h5></td>

                                </tr>
                                <tr>
                                    <td style="border-top: 0px solid black"><?php echo $result1['Education'];?></td>
                                    <td style="border-top: 0px solid black"><?php echo $result1['Occupation'];?></td>
                                </tr>
                            </table>

                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>

                            <h4 > Contact Information <hr></h4>
                            <table align="left" cellspacing="3" cellpadding="3" width="75%" class="table  ">
                            <tr>
                                <td style="border-top: 0px solid black"><h5><b>Phone Number</b></h5></td>
                                <td style="border-top: 0px solid black"><h5><b>Email Address</b></h5></td>
                                <td style="border-top: 0px solid black"><h5><b>Other Contact</b></h5></td>					
                            </tr>
                            <tr>
                                <td style="border-top: 0px solid black"><?php echo $result1['PhoneNum'];?></td>
                                <td style="border-top: 0px solid black"><?php echo $result1['Email'];?></td>
                                <td style="border-top: 0px solid black"><?php echo $result1['OtherContact'];?></td>
                            </tr>
                        </table>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>

                            <h4 >SECTORS <hr></h4>
                        <?php

                            $rows = $db_handle->runFetch("SELECT * FROM sector, idp_sector WHERE IDP_IDP_ID=$id AND idp_sector.SECTOR_SectorID = sector.SectorID");
                            foreach ($rows as $sql) {
                                echo  $sql['Name'] ; }
                                if(!empty($_POST['check_list'])){
                                    // Loop to store and display values of individual checked checkbox.
                                    foreach($_POST['check_list'] as $selected){
                                    echo $selected."</br>";
                                    }
                                }
                            }
                        }
                        ?>
                            </div>
                            <div class='modal-footer'>
                                <a id= '<?php echo($idp['IDP_ID']) ?>' class ='btn btn-primary btn-fill' style ='color:white' onclick='printDiv(this.id)'> PRINT
                                </a>
                            </div>
                        </div> <!-- IDP details container -->
                    
                        <div class="item">  <!-- IDP forms taken container -->
                            <div class="modal-header">
                            <span id = "<?php echo($idp['IDP_ID']) ?>" class="close" onclick="close_modal(this.id)">&times;</span>
                            <h2>
                                <?php echo($idp['Fname']) ?>&nbsp;<?php echo($idp['Mname']) ?>&nbsp;<?php echo($idp['Lname']) ?> 
                                <span><h5><sup>Form application history</sup></h5></span>
                            </h2>

                            </div>
                            <table align="left" cellspacing="3" cellpadding="3" width="75%" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="border-top: 0px solid black"></th>
                                        <th style="border-top: 0px solid black"><h6><b>Intake taken</b></h6></th>
                                        <th style="border-top: 0px solid black"><h6><b>Date taken</b></h6></th>
                                        <th style="border-top: 0px solid black"><h6><b>Previously interviewed?</b></h6></th>
                                        <th style="border-top: 0px solid black"><h6><b>Knew the organization?</b></h6></th>
                                        <th style="border-top: 0px solid black"><h6><b>If yes, name of the organization</b></h6></th>
                                        <th style="border-top: 0px solid black"><h6><b>Psychosocial report rating improvement</b></h6></th>
                                    </tr>
                                </thead>
                            <?php
                            $results = $db_handle->runFetch("SELECT intake_answers.IDP_IDP_ID as IDP, intake_answers.INTAKE_ANSWERS_ID, IF(intake_answers.INTAKE_IntakeID = 1, 'Intake for Adults', 'Intake for Children') as FormID, intake_answers.USER_UserID as User, intake_answers.Date_taken as DateTaken, 'N/A' as Score FROM intake_answers
                            JOIN
                            intake ON intake_answers.INTAKE_IntakeID = intake.IntakeID
                            where intake_answers.IDP_IDP_ID = ".$idp['IDP_ID']."
                            ORDER BY DateTaken DESC");
                            $order = 1;
                            if(!empty($results)) {
                            foreach ($results as $forms) {
                                $intake_answers = $db_handle->runFetch("SELECT
                                (SELECT Answer FROM answers_quanti JOIN intake_answers on intake_answers.INTAKE_ANSWERS_ID = answers_quanti.INTAKE_ANSWERS_INTAKE_ANSWERS_ID WHERE IDP_IDP_ID = ".$idp['IDP_ID']." AND INTAKE_ANSWERS_ID = ".$forms['INTAKE_ANSWERS_ID']." AND QUESTIONS_QuestionsID = 216) as Result1,
                                (SELECT Answer FROM answers_quanti JOIN intake_answers on intake_answers.INTAKE_ANSWERS_ID = answers_quanti.INTAKE_ANSWERS_INTAKE_ANSWERS_ID WHERE IDP_IDP_ID = ".$idp['IDP_ID']." AND INTAKE_ANSWERS_ID = ".$forms['INTAKE_ANSWERS_ID']." AND QUESTIONS_QuestionsID = 217) as Result2,
                                (SELECT Answer FROM answers_quali JOIN intake_answers on intake_answers.INTAKE_ANSWERS_ID = answers_quali.INTAKE_ANSWERS_INTAKE_ANSWERS_ID WHERE IDP_IDP_ID = ".$idp['IDP_ID']." AND INTAKE_ANSWERS_ID = ".$forms['INTAKE_ANSWERS_ID']." AND QUESTIONS_QuestionsID = 218) as Result3,
                                (SELECT Answer FROM answers_quanti JOIN intake_answers on intake_answers.INTAKE_ANSWERS_ID = answers_quanti.INTAKE_ANSWERS_INTAKE_ANSWERS_ID WHERE IDP_IDP_ID = ".$idp['IDP_ID']." AND INTAKE_ANSWERS_ID = ".$forms['INTAKE_ANSWERS_ID']." AND QUESTIONS_QuestionsID = 219) as Result4");
                            ?>
                                <tbody>
                                    <tr>
                                        <td>
                                            <?php echo $order; ?>
                                        </td>
                                        <td>
                                            <?php echo $forms['FormID']; ?>
                                        </td>
                                        <td>
                                            <?php echo $forms['DateTaken']; ?>
                                        </td>
                                        <?php foreach($intake_answers as $answer) { ?>
                                        <td>
                                            <?php
                                                if(isset($answer['Result1'])) {
                                                    echo ($answer['Result1']=='0'? 'Yes' : 'No');
                                                } else {
                                                    echo '(blank)';
                                                }
                                            ?>
                                            
                                        </td>
                                        <td>
                                            <?php
                                                if(isset($answer['Result2'])) {
                                                    echo ($answer['Result2']=='0'? 'Yes' : 'No');
                                                } else {
                                                    echo '(blank)';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if(isset($answer['Result3'])) {
                                                    echo $answer['Result3'];
                                                } else {
                                                    echo '(blank)';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if(isset($answer['Result4'])) {
                                                    if($answer['Result4'] == '0') {
                                                        echo 'No changes';
                                                    } else if($answer['Result4'] == '1') {
                                                        echo 'Slightly Improved (less than 20%)';
                                                    } else if($answer['Result4'] == '2') {
                                                        echo 'Moderately Improved (20%-60%)';
                                                    } else if($answer['Result4'] == '3') {
                                                        echo 'Much improved (60%-80%)';
                                                    } else if($answer['Result4'] == '4') {
                                                        echo 'Very much improved (more than 80%)';
                                                    }
                                                } else {
                                                    echo '(blank)';
                                                }
                                            ?>
                                        </td>
                                        <?php } ?>
                                        <?php $order++ ?>
                                    </tr>
                                </tbody>
                            <?php
                                }
                            } else {
                            ?>
                                    <tr>
                                        <td>
                                        </td>
                                        <td> No intakes taken yet.
                                        </td>
                                    </tr>
                            <?php
                            }
                            ?>
                                </table>
                            <div>
                                
                            </div>
                            <div>
                                <table align="left" cellspacing="3" cellpadding="3" width="75%" class="table assessment-table table-hover">
                                    <thead>
                                    <tr>
                                        <th style="border-top: 0px solid black"></th>
                                        <th style="border-top: 0px solid black"><h6><b>Assessment tool taken</b></h6></th>
                                        <th style="border-top: 0px solid black"><h6><b>Date taken</b></h6></th>
                                        <th style="border-top: 0px solid black"><h6><b>Score</b></h6></th>
                                        <th style="border-top: 0px solid black"><h6><b>Assessment</b></h6></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                            <?php
                            $results = $db_handle->runFetch("SELECT A.IDP_IDP_ID as IDP, A.FORM_ANSWERS_ID, FormType as FormID, A.USER_UserID as User, A.DateTaken, Score, A.UnansweredItems FROM
                            (SELECT form_answers.IDP_IDP_ID, form_answers.FORM_ANSWERS_ID, FormType, form_answers.USER_UserID, form_answers.DateTaken, form_answers.UnansweredItems FROM form_answers
                            JOIN form on form.FormID = form_answers.FORM_FormID
                            where form_answers.IDP_IDP_ID = ".$idp['IDP_ID'].") A
                            RIGHT JOIN
                            (SELECT DISTINCT(IDP_IDP_ID), FORM_ANSWERS_ID, COALESCE(SUM(answers_quanti.Answer),0) as Score FROM answers_quanti RIGHT JOIN form_answers ON form_answers.FORM_ANSWERS_ID = answers_quanti.FORM_ANWERS_FORM_ANSWERS_ID where form_answers.IDP_IDP_ID = ".$idp['IDP_ID']." GROUP BY FORM_ANWERS_FORM_ANSWERS_ID) B
                            ON A.FORM_ANSWERS_ID = B.FORM_ANSWERS_ID
                            ORDER BY DateTaken DESC");
                            $order = 1;
                            if(!empty($results)) {
                                foreach ($results as $forms) {
                                    if(!isset($forms['UnansweredItems'])) {
                                        echo '<tr id="'.$forms['FORM_ANSWERS_ID'].'" name="info-link">';
                                    } else {
                                        echo '<tr id="'.$forms['FORM_ANSWERS_ID'].'" name="info-link" class="bg-danger">';
                                    }
                            ?>
                                        <td>
                                            <?php echo $order; ?>
                                        </td>
                                        <td>
                                            <?php echo $forms['FormID']; ?>
                                        </td>
                                        <td>
                                            <?php echo $forms['DateTaken']; ?>
                                        </td>
                                        <?php
                                            if(!isset($forms['UnansweredItems'])) {
                                                echo '<td>'.$forms['Score'].'</td>';
                                            } else {
                                                echo '<td><h6><sup>PARTIAL</sup><h6>'.$forms['Score'].'</td>';
                                            }
                                        ?>
                                        <td>
                                            (under construction)
                                        </td>
                                        </tbody>
                                        <?php $order++ ?>
                                    
                            <?php
                                echo '</tr>';
                                }
                            } else {
                            ?>
                                    <tr>
                                        <td>
                                        </td>
                                        <td> No assessment tools taken yet.
                                        </td>
                                    </tr>
                            <?php
                            }
                            ?>
                                </table>
                            </div>
                        </div>
                        <!-- CONTROLLER -->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div> <!-- carousel container -->
                </div>
            </div>
        </div>
    </td>
</tr>
<script>
    $('tr[name="info-link"]').on("click", function() {
    document.location = 'view_answers.php?id='+this.id;
});
</script>
<?php
    }
}
?>