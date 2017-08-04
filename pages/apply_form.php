
<?php
require('check_credentials.php');
include ('head.php');
?>

<?php $ul_assessment = "active"; include ('sidebar.php'); ?>

    <div class="main-panel">
        
<?php include ('navbar.php'); ?>
<?php include ('footer.php'); ?>
<?php
    require_once("dbcontroller.php");
    $idpID = $_GET['id'];
    $userID = $_SESSION['userID'];
    $db_handle = new DBController();
    $forms = $db_handle->runFetch("SELECT * FROM `form` WHERE 1");
    $idp = $db_handle->runFetch("SELECT * FROM `idp` WHERE IDP_ID = ".$idpID);
    $idp_name;
    $idp_age_group;
?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" style="padding: 20px 50px;">
                        <!-- <div class="header"> -->
                            <h3><b>IDP Form Application</b></h3>
                        <!-- </div> -->
                        <div class="row">
                            <div class="col-md-12">
                                <p><i>This section is for the application of the different assessment Forms available to the selected IDP.</i></p>
                                <h4>Current IDP: 
                                    <?php if(!empty($idp)) {
                                        foreach ($idp as $result) {
                                            echo ('<b>'.$result['Lname'].', '.$result['Fname'].' '.$result['Mname'].'</b><br>IDP ID: <b>'.$result['IDP_ID'].'</b>');
                                            $idp_name = $result['Lname'].', '.$result['Fname'].' '.$result['Mname'];
                                            if($result['Age'] < 18) {
                                                $idp_age_group = 2;
                                            } else {
                                                $idp_age_group = 1;
                                            }
                                        }
                                    } ?>
                                        
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="submit_add_idp_form.php" method="post">
                                    <div class="form-group">
                                        <label for="formType"><h5><b>Select Form Type</b></h5></label>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <select class="form-control" name="formType">
                                                <b><?php
                                                    if(!empty($forms)) {
                                                        foreach ($forms as $form) {
                                                            echo ('<option name="'.$form['FormType'].'" value="'.$form['FormID'].'">'.$form['FormType'].'</option>');
                                                        }
                                                    }?>
                                                </b>    
                                                </select>
                                                <input type="hidden" name="idpID" value="<?php echo($idpID); ?>">
                                                <input type="hidden" name="idp_name" value="<?php echo($idp_name); ?>">
                                                <input type="hidden" name="previous_page" value="<?php echo($_SERVER['HTTP_REFERER']); ?>"> 
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-info btn-fill form-control" type="submit"><i class="fa fa-check"></i>&nbsp;Submit</button> 
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        