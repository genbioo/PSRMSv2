
<?php include ('head.php'); ?>

<?php $ul_index = "active"; $ul_forms = ""; $ul_idp =""; include ('sidebar.php'); ?>

    <div class="main-panel">
        
<?php include ('navbar.php'); ?>

<?php include ('footer.php'); ?>
<?php
require_once("dbcontroller.php");
$db_handle = new DBController();


?>

<style type="text/css">




.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0) !important; /* Fallback color */
    background-color: rgba(0,0,0,0.4) !important; /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    position: relative;
    top: 0% !important;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border: 1px solid #888;
    width: 50%;

    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 1s;
    animation-name: animatetop;
    animation-duration: 1s
}

/* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:30% !important; opacity:1}
}

@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:30% !important; opacity:1}
}

/* The Close Button */
.close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-header {
    padding: 2px 16px;
    background-color: #9368E9;
    color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
    padding: 2px 16px;
    background-color: #9368E9;
    color: white;
}



</style>
 <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">CSWD </h4> <br>



                                <p class="category"> <i class="fa fa-square-o"></i> IDPs will be listed here</p> <br>
                                <a class='btn btn-success' href='cswd.php'><i class='pe-7s-add-user'></i> Add New IDP</a>
                            </div>


              <div class="panel-body">
				
				<table class="table table-bordered table-advance table-hover ">
				   <tbody>
					  <tr>
						 <th><i class="icon_mobile"></i> IDP No.</th>
						 <th><i class="icon_profile"></i> Last Name</th>
						 <th><i class="icon_profile"></i> First Name</th>
						 <th><i class="icon_profile"></i> Middle Initial</th>
						 <th><i class="icon_pin_alt"></i> Gender</th>
						 <th><i class="icon_pin_alt"></i> Age</th>
						 <th><i class="icon_calendar"></i> Birth Date</th>
						 
						 <th><i class="icon_cogs"></i> Action</th>
					  </tr>
					  <?php
						

						$idps = $db_handle->runFetch("SELECT * FROM `idp` WHERE 1");
					if(!empty($idps)) {
           					 foreach ($idps as $idp) {
							  echo //Display table 
							  
							  '<tr>
								<td>'.$idp['IDP_ID'].'</td>
								<td>'.$idp['Lname'].'</td>
								<td>'.$idp['Fname'].'</td>
								<td>'.$idp['Mname'].'</td>';
								
							  $gender = $idp['Gender'];
							  if ($gender=="1"){
								echo ("<td>Male</td>");
							  }
							  else if($gender=="2"){
							  echo ("<td>Female</td>");
							  };
							  
							  echo '
							  
								<td>'.$idp['Age'].'</td>
								<td>'.$idp['Bdate'].'</td>
								
								<td>



<button class="btn btn-primary" id="'.$idp['IDP_ID'].'" onClick ="show_modal(this.id)"><i class="pe-7s-info"></i> View</button>

<!-- The Modal -->
<div id="myModal'.$idp['IDP_ID'].'" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span id = "'.$idp['IDP_ID'].'" class="close">&times;</span>
      <h2>'.$idp['Fname'].'&nbsp' .$idp['Mname'].'&nbsp' .$idp['Lname'].' 
</h2>

    </div>
    <div class="modal-body">'; 




  $id = $idp['IDP_ID'];
 ;
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
					<td style="border-top: 0px solid black"><h5><b>Relation</b></h5></td>
					
				</tr>
				<tr>
					<td style="border-top: 0px solid black"><?php echo $result1['Bdate'];?></td>
					<td style="border-top: 0px solid black"><?php echo $result1['Age'];?></td>
					<td style="border-top: 0px solid black"><?php
				
					 
						
						  $gender = $result1['Gender'];
						  if ($gender=="1"){
							echo "<option value ='1'>Male</option>";

						  }
						  else if($gender=="2"){
							echo "<option value ='2'>Female</option>";
						  }
					
					?></td>
					<td style="border-top: 0px solid black">
					<?php

							  $mar = $result1['MaritalStatus'];
							  if ($mar=="1"){
								echo "<option value ='1'>Single</option>";
								
							  }
							  else if($mar=="2"){
								echo "<option value ='2'>Female</option>";
								
							  }
							  else if($mar=="3"){
								echo "<option value='3'>Annulled</option>";
								
							  }
							  else if($mar=="4"){
								echo "<option value='4'>Widowed</option>";
								
							  
						}
						?></td>
						<td style="border-top: 0px solid black"><?php echo $result1['RelationToHead'];?></td>
				</tr>
				</table>
				<br>
				<br>
				<br>
				<br><br>
				<br>
			<h4>Original Address <hr></h4>
				<table align="left" cellspacing="3" cellpadding="3" width="75%" class="table  ">
					
					<tr>
						<td style="border-top: 0px solid black"><h5><b>Street/Purok</b></h5></td>
						<td style="border-top: 0px solid black"><h5><b>Barangay</b></h5></td>
						<td style="border-top: 0px solid black"><h5><b>City/Municipality</b></h5></td>
						<td style="border-top: 0px solid black"><h5><b>District</b></h5></td>
						<td style="border-top: 0px solid black"><h5><b>Province</b></h5></td>
						
						
						
					</tr>
					<tr>
						<td style="border-top: 0px solid black"></td>
						<td style="border-top: 0px solid black"><?php $b_id =$result1['Origin_Barangay'];  $barangays = $db_handle->runFetch("SELECT * FROM barangay WHERE BarangayID = $b_id");
							
								foreach ($barangays as $barangay) {
									$c_id =$barangay['City_CityID'];
								echo $barangay['BarangayName'];								}
							?></td>
						<td style="border-top: 0px solid black"><?php   $citys = $db_handle->runFetch("SELECT * FROM city_mun WHERE City_Mun_ID = $c_id");
							
								foreach ($citys as $city) {
									$p_id = $city['PROVINCE_ProvinceID'];
								echo $city['City_Mun_Name'];								}
							?></td>
				
						<td style="border-top: 0px solid black"><?php echo $result1['Bdate'];?></td>
							<td style="border-top: 0px solid black"><?php   $provinces = $db_handle->runFetch("SELECT * FROM province WHERE ProvinceID = $p_id");
							
								foreach ($provinces as $province) {
									//$p_id = $city['PROVINCE_ProvinceID'];
								echo $province['ProvinceName'];								}
							?></td>
					</tr>
				</table>
				<br>
				<br>
				<br>
				<br><br>
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
				<br><br>
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
				<br><br>
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


}}?>










<?php
   echo "


    </div>
    <div class='modal-footer'>
    
		<a id= '".$idp['IDP_ID']."' class ='btn btn-primary' style ='color:white' onclick='printDiv(this.id);'> PRINT </a>
   	
    </div>
  </div>

</div>





















								 
								 <a class='btn btn-danger' href='deletecswd.php?id={$idp['IDP_ID']}'><i class='pe-7s-delete-user'></i> Update </a>
								 <a class='btn btn-warning' href='intakeform.php?id={$idp['IDP_ID']}'><i class='icon_check_alt'></i> Apply Intake</a>
							  </td>
							  </tr>
						  ";
						}
					}
					  ?>
				   </tbody>
				</table>
			</div>
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->
  </section>
  <!-- container section end -->
    <!-- javascripts -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- nice scroll -->
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script><!--custome script for all page-->
    <script src="js/scripts.js"></script>
	<script>

function show_modal(clicked_id){




// Get the modal
var modal = document.getElementById('myModal' + clicked_id);

// Get the button that opens the modal
var btn = document.getElementById("" + clicked_id);

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close");
//alert(span.length);
// When the user clicks the button, open the modal 
//btn.onclick = function() {
    modal.style.display = "block";


// When the user clicks on <span> (x), close the modal
for(i =0; i<= span.length; i++){
	span[i].onclick = function() {
	//alert("true");
    modal.style.display = "none";
}
window.onclick = function(event) {
	//alert("true");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

}


// When the user clicks anywhere outside of the modal, close it








}




function printDiv(clicked_id) 
{

  var divToPrint=document.getElementById('myModal' + clicked_id);

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}

	</script>
