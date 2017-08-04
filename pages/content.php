<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
$forms = $db_handle->runFetch("SELECT * FROM `form` WHERE 1");

?>
<div id="page-wrapper">



 <!--Evacuees--->
    <div id="section0">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Evacuees</h1>
                <select id="mySelect" onChange = "getValue()">
               <option selected disabled>Evacuation Centers</option>
                  <?php
                  
                  $e_centers = $db_handle->runFetch("SELECT * FROM `evacuation_centers` WHERE 1;");
                  if(!empty($e_centers)) { 
                  ?>
                 
        <?php
        foreach ($e_centers as $e_center) {
        echo ' <option value="'.$e_center['EvacuationCentersID'].'">'.$e_center['EvacName'].'</option>
                 

        ';
        }} ?>

                </select>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row" id="main">
        <?php

        if(isset($_GET["e_id"]))
        {
        $e_id = $_GET["e_id"];
        $_SESSION['e_id'] = $e_id;
        
        if($e_id == "Evacuation Centers" || !isset($e_id) )
        {

        $idps = $db_handle->runFetch("SELECT DAFAC_DAFAC_SN,IDP_ID,Lname,Fname,MI,Gender,Age FROM `idp` WHERE 1;");
            
        }
        else {
        $idps = $db_handle->runFetch("SELECT DAFAC_DAFAC_SN,IDP_ID,Lname,Fname,MI,Gender,Age FROM `idp` WHERE `EvacuationCenters_EvacuationCentersID` = $e_id;");}
        if(!empty($idps)) { 
        ?>
        <table align="center" cellspacing="3" cellpadding="3" width="75%" class="table-striped table-hover">
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
        <td align="left">' . $idp['Lname'] . ', '.$idp['Fname'].' '.$idp['MI'].'</td>
        <td align="left">' . $idp['Gender'] . '</td>
        <td align="left">' . $idp['Age'] . '</td>
        <td align="left"><a href="take_form.php?id=' . $idp['IDP_ID'] . '">Apply Form</a></td>
        </tr>
        ';
        }}} ?>
        </table>
        </div>
    </div>








    <!--FORMS CONTENT--->
    <div id="section1">
        <div class="row">
            <div class="col-md-3">
                <h1 class="page-header">Forms   <a href="add_form.php?id=<?php echo($_SESSION['agencyID']); ?>" class="btn btn-info btn-xs" role="button">add form</a></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row" id="main">
        <table align="center" cellspacing="3" cellpadding="3" width="75%" class="table-striped table-hover">
        <tr>
            <?php //<td align="left"><b>NGO Form ID</b></td> ?>
            <td align="left"><b>Form Name</b></td>
            <td align="left"><b>Action</b></td>
            
        </tr>
        <?php if(!empty($forms)) {
            foreach ($forms as $form) {
            //<td align="left">' . $form['NGO_FORM_ID'] . '</td>
            echo '<tr>
            <td align="left">' . $form['FormType'] . '</td>
            <td align="left"><a href="edit_form.php?form_id=' . $form['FormID'] . '&form_name='.$form['FormType'].'">Edit</a></td>
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
    <div id="section2">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">IDPs</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row" id="main">
        <?php
        $idps = $db_handle->runFetch("SELECT DAFAC_DAFAC_SN,IDP_ID,Lname,Fname,MI,Gender,Age FROM `idp` WHERE 1;");
        if(!empty($idps)) { 
        ?>
        <table align="center" cellspacing="3" cellpadding="3" width="75%" class="table-striped table-hover">
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
        <td align="left">' . $idp['Lname'] . ', '.$idp['Fname'].' '.$idp['MI'].'</td>
        <td align="left">' . $idp['Gender'] . '</td>
        <td align="left">' . $idp['Age'] . '</td>
        <td align="left"><a href="take_form.php?id=' . $idp['IDP_ID'] . '">Apply Form</a></td>
        </tr>
        ';
        }} ?>
        </table>
        </div>
    </div>























</div>



<script>
function getValue() {

   window.location.href = "dashboard.php?e_id=" +  document.getElementById("mySelect").value ;

               
}
</script>
