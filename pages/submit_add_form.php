<?php
require_once("dbcontroller.php");
$formType = $_POST['formType'];
$formInstructions = $_POST['formInstructions'];
$db_handle = new DBController();
if (empty($formType)) {
     echo "<script type='text/javascript'>alert('empty field!');
     location='dashboard.php#?';</script>";
} else {
    /*$question = $db_handle->runUpdate("INSERT INTO `ngo_form` (`NGO_FORM_ID`, `FORM_FormID`, `AGENCY_AgencyID`) VALUES (NULL, '".$id."', '".$agencyID."')");*/
    
    $form = $db_handle->runUpdate("INSERT INTO `form` (`FormID`, `FormType`, `Instructions`) VALUES (NULL, '".$formType."', \"".nl2br($formInstructions)."\")");
    
    if($db_handle->getUpdateStatus()) {
        echo "<script type='text/javascript'>alert('Add Succesful!');
        location='forms.php';
        </script>";
    }
    /*$db_handle->conn->quote(nl2br($formInstructions))*/
}
?>