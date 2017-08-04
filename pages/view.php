

<?php




  $id = $idp['IDP_ID'];

echo $id;


$idps = $db_handle->runFetch("SELECT * FROM idp WHERE IDP_ID =$id");

  $idp_sectors = $db_handle->runFetch("SELECT * FROM idp_sector WHERE IDP_IDP_ID = $id");



      $dafac_nos = $db_handle->runFetch("SELECT * FROM dafac_no WHERE DAFAC_SN = $id");
          $query2 = $db_handle->runFetch("SELECT * FROM idp, city_mun,province,barangay WHERE IDP_ID = $id AND Origin_Barangay=BarangayID AND City_Mun_ID = City_CityID AND PROVINCE_ProvinceID=ProvinceID");

  


  //$query3 = mysql_query("SELECT * FROM barangay, idp WHERE IDP_ID = $id AND Origin_Barangay=BarangayID ") or die(mysql_error());
if(!empty($idps)) {
	//	echo "true 1asdasd";
foreach ($idps as $result1) {
	
//foreach ($idp_sectors as $result2 ) {

		if(!empty($query2)) {
			echo "true";
foreach ($query2 as $result3 ) {
 
?>

 
        <div id="invoice">
          <div class="serial">Date Taken: <?php echo $result1['DateTaken'];?></div>
		  <h2>IDP No: <u><?php echo $result1['IDP_ID'];?></u></h2>
		  <h2>IDP Name: <u><?php echo $result1['Lname'].' '.$result1['Fname'].' '.$result1['Mname'];?></u></h2>
        </div>
	  
	  
		<div class="row">
		<h3 style="text-align:center">PERSONAL INFORMATION</h3>
			<table>
				<tr>
					<td><h4>Birthdate</h4></td>
					<td><h4>Age</h4></td>
					<td><h4>Gender</h4></td>
					<td><h4>Marital Status</h4></td>
					<td><h4>Relation</h4></td>
					
				</tr>
				<tr>
					<td><?php echo $result1['Bdate'];?></td>
					<td><?php echo $result1['Age'];?></td>
					<td><?php
				
					  $rows = $db_handle->runFetch("SELECT * FROM idp WHERE IDP_ID=$id");
					  
					foreach ($rows as $row) {
						
						  $gender = $row['Gender'];
						  if ($gender=="1"){
							echo "<option value ='1'>Male</option>";

						  }
						  else if($gender=="2"){
							echo "<option value ='2'>Female</option>";
						  }
					}
					?></td>
					<td>
					<?php

						 
						  $rows = $db_handle->runFetch("SELECT * FROM idp WHERE IDP_ID=$id");
					  
					foreach ($rows as $row) {
							  $mar = $row['MaritalStatus'];
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
						}
						?></td>
						<td><?php echo $result1['RelationToHead'];?></td>
				</tr>
				</table>
			<p>Origin</p>
				<table>
					<tr>
						<td><h4>Province</h4></td>
						<td><h4>City/Municipality</h4></td>
						<td><h4>District</h4></td>
					</tr>
					<tr>
						<td><?php echo $result1['Bdate'];?></td>
						<td><?php echo $result1['Age'];?></td>
						<td><?php echo $result1['Age'];?></td>
					
					</tr>
				</table>
				
				<table>
					<tr>
						<td><h4>Barangay</h4></td>
						<td><h4>Street/Purok</h4></td>
						
					</tr>
					<tr>
						<td><?php echo $result1['Bdate'];?></td>
						<td><?php echo $result1['Age'];?></td>
					</tr>
				</table>
				
				<table>
					<tr>
						<td><h4>Educational Attainment</h4></td>
						<td><h4>Employment</h4></td>
						
					</tr>
					<tr>
						<td><?php echo $result1['Bdate'];?></td>
						<td><?php echo $result1['Age'];?></td>
					</tr>
				</table>
		</div>
		
		<div class="row">
		<h3 style="text-align:center">CONTACT INFORMATION</h3>
			<table>
				<tr>
					<td><h4>Phone Number</h4></td>
					<td><h4>Email Address</h4></td>
					<td><h4>Other Contact</h4></td>					
				</tr>
				<tr>
					<td><?php echo $result1['PhoneNum'];?></td>
					<td><?php echo $result1['Email'];?></td>
					<td><?php echo $result1['OtherContact'];?></td>
				</tr>
			</table>
		</div>
		
		<div class="row">
		<h3 style="text-align:center">SECTORS</h3>
		<?php

 $rows = $db_handle->runFetch("SELECT * FROM sector, idp_sector WHERE IDP_IDP_ID=$id AND idp_sector.SECTOR_SectorID = sector.SectorID");
					  
					foreach ($rows as $sql) {

		echo "sadasdasd" . $sql['Name'] ; }
		
		if(!empty($_POST['check_list'])){
		// Loop to store and display values of individual checked checkbox.
		foreach($_POST['check_list'] as $selected){
		echo $selected."</br>";
		}
		}


}}}}?>
		</div>
	  
    </main>	  	  
    <div id="notices">
		<div>NOTICE:</div>
        <div class="notice">This page is printer-friendly. Click here to <a href='#' onClick='window.print()' />print</a></div>
    </div>

  