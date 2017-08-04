<?php include ('check_credentials.php'); ?>
<?php
unset($_SESSION['form_id']);
unset($_SESSION['form_name']);
?>

<?php 
$ul_forms = "active";
include ('sidebar.php'); ?>

<?php include ('head.php');?>

<div class="main-panel">
        
<?php include ('navbar.php'); ?>
<?php  include ('modal.php'); ?>
<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
$forms = $db_handle->runFetch("SELECT * FROM `form` WHERE 1");

?>






   <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h3 class="title"><b>Forms</b></h3> <br>
                            <!--<p class="category">Forms will be listed here</p>-->
                            
                        </div>
                            <div class="content">
                                <div id="formPreferences" class="ct-forms ct-perfect-fourth">
        

        <table align="left" cellspacing="3" cellpadding="3" width="75%" class="table table-bordered table-advance table-hover ">
                <tr>
                    <?php //<td align="left"><b>NGO Form ID</b></td> ?>
                    <td align="left"><b>Assessment form Name <button class="btn btn-success btn-fill btn-md" onClick ="show_modal()" role="button"><i class="fa fa-plus"></i>Add Assessment Tool</button></b></td>
                    <td align="left"><b>Action</b></td>

                </tr>
                <?php if(!empty($forms)) {
                    foreach ($forms as $form) {
                    //<td align="left">' . $form['NGO_FORM_ID'] . '</td>
                    echo '<tr>
                    <td align="left">' . $form['FormType'] . '</td>
                    <td align="left"><button class="btn btn-warning btn-fill center-block"><a href="edit_form.php?form_id=' . $form['FormID'] . '&form_name='.$form['FormType'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Tool</a></button></td>
                    </tr>
                    ';
                    }
                } else {
                    echo '<tr>
                        <td>No forms available!</td>
                    </tr>';
                }?>
            </table>
            <br>
            <table align="left" cellspacing="3" cellpadding="3" width="75%" class="table table-bordered table-advance table-hover ">
                <tr>
                    <?php //<td align="left"><b>NGO Form ID</b></td> ?>
                    <td align="left"><b>Intake form [Disaster - Age group] <button class="btn btn-success btn-fill btn-md" onClick ="show_modal()" role="button"><i class="fa fa-plus"></i>Create Intake Form</button></b></td>
                    <td align="left"><b>Action</b></td>

                </tr>
                <?php if(!empty($intakes)) {
                    foreach ($intakes as $intake) {
                    //<td align="left">' . $form['NGO_FORM_ID'] . '</td>
                    echo '<tr>
                    <td align="left">' . $intake['DisasterName'] . ' - ';
                    if($intake['AgeGroup'] === '1') {
                        echo ("Intake for adults");
                    } else if ($intake['AgeGroup'] === '2') {
                        echo ("Intake for children");
                    }
                    echo '</td>
                    <td align="left"><button class="btn btn-warning btn-fill center-block"><a href="edit_intake.php?form_id=' . $form['FormID'] . '&form_name='.$form['FormType'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit Form</a></button></td>
                    </tr>
                    ';
                    }
                } else {
                    echo '<tr>
                        <td>No forms available!</td>
                    </tr>';
                }?>
            </table>
        </div>
    </div>
    
    <!--IDP CONTENT--->
    <div id="section1" style="display: none;">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">IDPs</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row" id="main">
        <?php
        $idps = $db_handle->runFetch("SELECT * FROM `idp` LEFT JOIN intake_answers on IDP_ID = intake_answers.IDP_IDP_ID");
        if(!empty($idps)) { 
        ?>
        <table align="left" cellspacing="3" cellpadding="3" width="75%" class="table table-bordered table-advance table-hover ">
        <tr>
            <td align="left"><b>Family ID</b></td>
            <td align="left"><b>IDP ID</b></td>
            <td align="left"><b>Name</b></td>
            <td align="left"><b>Gender</b></td>
            <td align="left"><b>Age</b></td>
            <td align="left"><b>Action</b></td>

        </tr>
        <?php
        foreach ($idps as $idp) {
        echo '<tr>
            <td align="left">' . $idp['DAFAC_DAFAC_SN'] . '</td>
            <td align="left">' . $idp['IDP_ID'] . '</td>
            <td align="left">' . $idp['Lname'] . ', '.$idp['Fname'].' '.$idp['Mname'].'</td>
            <td align="left">';
            echo(($idp['Gender'] == 1) ? 'Male' : 'Female');
            echo '</td>
            <td align="left">' . $idp['Age'] . '</td>
            <td align="left">';
            $idp_age_group = ($idp['Age'] < 18) ? 2 : 1;
            if(!isset($idp['INTAKE_IntakeID'])) {
                echo '<a href="apply_intake.php?id=' . $idp['IDP_ID'] . '&ag=' . $idp_age_group . '" class="btn btn-info btn-xs">Apply Intake</a>';
            } else {
                echo '<a href="apply_intake.php?id=' . $idp['IDP_ID'] . '&ag=' . $idp_age_group . '" class="btn btn-info btn-xs">Apply Intake</a>';
                echo '<a href="apply_form.php?id=' . $idp['IDP_ID'] . '" class="btn btn-info btn-fill btn-xs">Apply Assessment Form</a>';
            }
            echo '
            </td>
        </tr>
        ';
        }} ?>
        </table>
                                


                                </div>

                            
                            </div>
                        </div>
                    </div>

                    </div>
                    </div>





<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header" style="height: 50px;">
    <h4 class="modal-title">Add New Form</h4>
    </div>
    <div class="modal-body"> 
            <form action="submit_add_form.php" method="post" style="margin-bottom: 20px;">
                <tr>
                    <td>
                        <br><label for="formType">Form name:</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text"  class="form-control" name="formType" id="formType">
                        <input type="hidden" name="previous_page" value="<?php echo($_SERVER['HTTP_REFERER']); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <br><label for="formInstructionse">Form Instructions:</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <textarea class="form-control" rows="5" name="formInstructions" id="formInstructions"></textarea>
                        <?php //<input type="text"  class="form-control" name="formInstructions" id="formInstructions"> ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br><button class="btn btn-info btn-fill" type="submit"><i class="fa fa-check"></i>Submit</button>
                    </td>
                </tr>
            </form>
      </div>
    </div>
  </div> 
    </div>
  </div>
<script type="text/javascript" src="../js/jquery-1.12.4.js"></script>
<script type="text/javascript" src="../js/edit_form-functions.js"></script>

