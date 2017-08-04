<?php include ('check_credentials.php'); ?>
<?php include ('head.php'); ?>

<?php $ul_index = ""; $ul_forms = ""; $ul_idp ="active";include ('sidebar.php'); ?>

    <div class="main-panel">
        
<?php include ('navbar.php'); ?>
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
                                <h4 class="title">IDPs &nbsp&nbsp&nbsp  </h4> <br>



                                <select id="mySelect" onChange = "getValue()">
               					<option selected disabled>Evacuation Centers</option>
                  				<?php
                  					$e_centers = $db_handle->runFetch("SELECT * FROM `evacuation_centers` WHERE 1;");
                  					if(!empty($e_centers)) { 
                  						foreach ($e_centers as $e_center) {
       										echo ' <option value="'.$e_center['EvacuationCentersID'].'">'.$e_center['EvacName'].'</option>';
										 }} 
								?>
								</select>
                            </div>
                            <div class="content">
                                <div id="idpPreferences" class="ct-idp ct-perfect-fourth">





        <?php

        if(isset($_GET["e_id"]))
        {
       			 $e_id = $_GET["e_id"];
       			 $_SESSION['e_id'] = $e_id;
        

        		$idps = $db_handle->runFetch("SELECT DAFAC_DAFAC_SN,IDP_ID,Lname,Fname,MI,Gender,Age FROM `idp` WHERE `EvacuationCenters_EvacuationCentersID` = $e_id;");
        		 }
       			else 
       			{
        			
        			$idps = $db_handle->runFetch("SELECT DAFAC_DAFAC_SN,IDP_ID,Lname,Fname,MI,Gender,Age FROM `idp` WHERE 1;");
		            
		        
        		}

        		if(!empty($idps)) { 

        
        ?>
        <table align="left" cellspacing="3" cellpadding="3" width="75%" class="table-striped table-hover">
        	<tr>
	            <td align="left"><b>Family ID</b></td>
	            <td align="left"><b>IDP ID</b></td>
	            <td align="left"><b>Name</b></td>
	            <td align="left"><b>Gender</b></td>
	            <td align="left"><b>Age</b></td>
	            <td align="left"><b>Action</b></td>

       		 </tr>

        <?php
        	foreach ($idps as $idp) 
        	{
		        echo '<tr>
		        <td align="left">' . $idp['DAFAC_DAFAC_SN'] . '</td>
		        <td align="left">' . $idp['IDP_ID'] . '</td>
		        <td align="left">' . $idp['Lname'] . ', '.$idp['Fname'].' '.$idp['MI'].'</td>
		        <td align="left">' . $idp['Gender'] . '</td>
		        <td align="left">' . $idp['Age'] . '</td>
		        <td align="left"><a href="take_form.php?id=' . $idp['IDP_ID'] . '">Apply Form</a></td>
		        </tr>
		        ';
        	}
        	}



        ?>
        </table>
       







<script>
function getValue() {

   window.location.href = "?e_id=" +  document.getElementById("mySelect").value ;

               
}
</script>
<?php include ('footer.php'); ?>