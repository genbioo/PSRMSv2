
<?php include ('check_credentials.php'); ?>
<?php include ('footer.php'); ?>
<?php include ('head.php'); ?>
<?php $ul_index = "active"; $ul_forms = ""; $ul_idp =""; include ('sidebar.php'); ?>

    <div class="main-panel">
        
<?php include ('navbar.php'); ?>
<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
  //$id = $_GET['id'];

?>
  <form method="POST" action="adddemo.php">
       <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        

              <!-- page start-->
              <div class="row">
                <div class="col-lg-12">
                   
					    <div class="row">
					    
							<div  id = "personal_info_div" class="col-lg-6">
                                <div class="panel panel-success">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    <div class="panel-heading">Personal Information</div>
									</a>
                                        <div class="panel-body panel-collapse collapse in" id="collapseOne">
                                            <div class="form-group col-md-12">
                                                <label>Last Name*</label>
                                                <input class="form-control" id = 'Lname' name='Lname' placeholder="Enter Last name" >
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>First Name*</label>
                                                <input class="form-control" name='Fname' placeholder="Enter First name" >
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Middle Name*</label>
                                                <input class="form-control" name='Mname' placeholder="Enter Middle Name" >
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>Date of birth*</label>
                                                <input type="date" name='Bdate' class="form-control" >
                                                    
                                            </div>
                                            
                                            <div class="form-group col-md-12">
                                                <label>Age*</label>
                                                <input class="form-control" name='Age' placeholder="Enter age" type="number" min="0" >
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Gender*</label>
                                                <select name='Gender' class="form-control" >
                                                    <option value="1">Male</option>
                                                    <option value="2">Female</option>
                                                </select>             
                                            </div>

                                             <div class="form-group col-md-12">
                                                <label>Ethnicity*</label>
                                                <select name='Ethnicity' class="form-control" >
                                                    <option value="1">Maranao</option>
                                                    <option value="2">Cebuano</option>
                                                </select>             
                                            </div>

                                             <div class="form-group col-md-12">
                                                <label>Religion*</label>
                                                <select name='Religion' class="form-control" >
                                                    <option value="1">Islam</option>
                                                    <option value="2">Roman Catholic</option>
                                                </select>             
                                            </div>

																<div class="form-group col-md-12">
                                                <label>Marital Status*</label>
                                                <select name='MaritalStatus' class="form-control" >
                                                    <option value="1">Single</option>
                                                    <option value="2">Married</option>
																	 <option value="3">Annulled</option>
																	 <option value="4">Widowed</option>
                                                </select>             
                                            		</div>

											<div class="form-group col-sm-12">
												<label>Relation to the family head*</label>
												<select class="form-control col-md-12" id="relation" name='relation'  >

													<option>  <label>Relation to the family head*</label> </option>
													<option value="1">Head</option>
													<option value="2">Wife</option>
													<option value="3">Son</option>
													<option value="4">Daughter</option>
													<option value="other">Others</option>
												</select>
												</div>

												<div class="form-group col-md-12" id = 'serial_no_div'>
                                                <label>Serial No*</label>
                                                <input class="form-control" id = 'serial_no' name='serial_no' placeholder="Enter Serial No" >
                                                <br>
                                                
                                          		  </div>




												<div id="displayHead"  class="form-group">	
												<label>Select Head of the Family:</label>
												<select class="form-control" id= 'selected_head' name='selected_head' >
												<option>  <label>Select Head of the Family*</label> </option>
													<?php

                         								 $results = $db_handle->runFetch("SELECT * FROM dafac_no");
               
                             							 foreach ($results as $result) {
                              
													?>
														<option value='<?= $result['DAFAC_SN']; ?>' ><?= $result['Name']; ?></option>
													<?php } ?>
													
												</select>
												<div class="form-group">
													<label>If family head do not exist.</label>
													<input id='target2' class="form-control" style='display:none' type='text' name='relationOther' placeholder="Enter head of the family"/>
												</div>
											</div>
										  
											<div class="form-group col-md-12">
												<label>Educational Attainment*</label>
												<div class="row">
													<div class="col-md-6">
														<select class="form-control" id="education" onchange = "ShowHideDiv()">
																<option value="elementary">Elementary</option>
																<option value="highschool">Highschool</option>
																<option value="college">College</option>    
														</select>
													</div>
													<div class="col-md-6">
														<select class="form-control" name='education' id="elementary1">
																<option value="1">Grade 1</option>
																<option value="2">Grade 2</option>
																<option value="3">Grade 3</option>
																<option value="4">Grade 4</option>
																<option value="5">Grade 5</option>
																<option value="6">Grade 6</option>
																<option value="7">Elementary Graduate</option>												 
														</select>
														<select class="form-control" name='education' id="highschool1" style="display: none;">
																<option value="8">Grade 7</option>
																<option value="9">Grade 8</option>
																<option value="10">Grade 9</option>
																<option value="11">Grade 10</option>
																<option value="12">Grade 11</option>
																<option value="13">Grade 12</option>
																<option value="14">High School Graduate</option>
																
														</select>
														<select class="form-control" name='education' id="college1" style="display: none;">
																<option value="15">1st year</option>
																<option value="16">2nd year</option>
																<option value="17">3rd year</option>
																<option value="18">4th year</option>      
																<option value="19">College Graduate</option>

														</select>
													</div>
													<!--/.col-md-6-->
												</div>
												<!--/.row-->
											</div>
                                            
                                            <div class="form-group col-md-12">
                                                <label>Employment/Occupation</label>
                                                <input class="form-control" name="occupation" placeholder="Enter occupation" >
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Monthly Net Income</label>
                                                <input class="form-control" name="net_income" placeholder="Enter Monthly Income " >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                	<div id = "contact_div">
                                <div class="col-lg-6">
										<div class="panel panel-success" id="accordion">
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
										<div class="panel-heading">Contact Information</div>
										</a>
											<div class="panel-body panel-collapse collapse in" id="collapseFour">                           
												<div class="form-group col-md-6">
													<label>Phone Number*</label>
													<input class="form-control" name='PhoneNum' placeholder="Enter phone number" id = "PhoneNum">
												</div>
												<div class="form-group col-md-6">
													<label>Email*</label>
													<input class="form-control" id='Email' name='Email' placeholder="your@mail.com">
												</div>
												<div class="form-group col-md-6">
													<label>Other Contact*</label>
													<input class="form-control" id='OtherContact' name='OtherContact' placeholder="Enter other contact">
												</div>
											</div>
									</div>
								</div>
								</div>


								<div id = "relocation_div">
								<div class="col-lg-6">
									<div class="panel panel-success" id="accordion">
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
										<div class="panel-heading">Relocation Address</div>
										</a>
											<div class="panel-body panel-collapse collapse in" id="collapseThree">      
                                                    <div class="form-group col-md-12">
                                                     
                                                      
                                                <select class="form-control" name="EvacType" id="EvacType" >
                                        	<option>  <label>Type of Relocation*</label> </option>
                    										<option value="1">Evacuation Center</option>
                    										<option value="2">Home-based</option>
                    									</select> 
                                                    </div> 
                                                    <div id="EvacName" class="form-group  col-md-12">
													<label>Name of the Evacuation Center*</label>
													<select name="EvacName" class="form-control">
														<?php

                             								$results = $db_handle->runFetch("SELECT * FROM evacuation_centers");
               
                    							 			foreach ($results as $result) {

														?>
														<option value="<?= $result['EvacuationCentersID']; ?>"><?= $result['EvacName']; ?></option>
														<?php } ?>
													</select> 
													</div>
													<div id = "home_based_div">
													<div class="form-group col-md-12">
													<label for="province">Province* for home-based</label>
													<select name='province' id='province' class="form-control" >
														<?php
                            							 $results = $db_handle->runFetch("SELECT * FROM province");
               
                          									foreach ($results as $result) {
														?>
														<option value="<?= $result['ProvinceID']; ?>"><?= $result['ProvinceName']; ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="form-group col-md-12">
													<label>District* for home-based</label>
													<select name='district' id='district' class="form-control" >
														<?php
                                 						$results = $db_handle->runFetch("SELECT * FROM district");
               
                        								  foreach ($results as $result) {
														?>
														<option value="<?= $result['DistrictID']; ?>"><?= $result['DistrictName']; ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="form-group col-md-12">
													<label>City/Municipality* for home-based</label>
													<select name="city_mun" id="city_mun" class="form-control" >
														<?php


                               						 $results = $db_handle->runFetch("SELECT * FROM city_mun, province WHERE city_mun.PROVINCE_ProvinceID=province.ProvinceID");
               
                         								 foreach ($results as $result) {

														?>
														<option value="<?= $result['City_Mun_ID']; ?>"><?= $result['City_Mun_Name']; ?></option>
														<?php } ?>
													</select>  
												</div>
												<div class="form-group col-md-12">
													<label>Barangay* for home-based</label>
													<select name="barangay2" id="barangay2" class="form-control" >
														<?php

                                					$results = $db_handle->runFetch("SELECT * FROM barangay, city_mun WHERE barangay.City_CityID=city_mun.City_Mun_ID");
               
                        							 foreach ($results as $result) {
														?>
														<option value="<?= $result['BarangayID']; ?>"><?= $result['BarangayName']; ?></option>
														<?php } ?>
													</select> 
												</div>
												<div class="form-group col-md-12">
													<label>Street/Purok*for home-based</label>
													<input class="form-control" name="SpecificAddress1" placeholder="144 Purok Sampaguita" type="textbox"/>
												</div>
												
												</div>
											</div>
										</div>
									</div>
									</div>

										<div id = "home_address_div">
										<div class="col-lg-6">
											<div class="panel panel-success" id="accordion">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
												<div class="panel-heading">Home Address</div>
												</a>
													<div class="panel-body panel-collapse collapse in" id="collapseTwo"> 
														<div class="form-group col-md-12">
															<label for="province">Province*</label>
															<select name='province' id='province' class="form-control">
																<?php

										                            $results = $db_handle->runFetch("SELECT * FROM province");
										               
										                          foreach ($results as $result) {

																?>
																<option value="<?= $result['ProvinceID']; ?>"><?= $result['ProvinceName']; ?></option>
																<?php } ?>
															</select>
														</div>
														<div class="form-group col-md-12">
															<label>District*</label>
															<select name='district' id='district' class="form-control">
																<?php

		                            								 $results = $db_handle->runFetch("SELECT * FROM district");
		               												 foreach ($results as $result) {
																?>
																<option value="<?= $result['DistrictID']; ?>"><?= $result['DistrictName']; ?></option>
																<?php } ?>
															</select>
														</div>
														<div class="form-group col-md-12">
															<label>City/Municipality*</label>
															<select name="city_mun" id="city_mun" class="form-control">
																<?php

									                             $results = $db_handle->runFetch("SELECT * FROM city_mun, province WHERE city_mun.PROVINCE_ProvinceID=province.ProvinceID");
		               
		                          									foreach ($results as $result) {
																?>
																<option value="<?= $result['City_Mun_ID']; ?>"><?= $result['City_Mun_Name']; ?></option>
																<?php } ?>
															</select>  
														</div>
														<div class="form-group col-md-12">
															<label>Barangay*</label>
															<select name="barangay1" id="barangay1" class="form-control" >
																<?php


									                             $results = $db_handle->runFetch("SELECT * FROM barangay, city_mun WHERE barangay.City_CityID=city_mun.City_Mun_ID");
									               
									                          	foreach ($results as $result) {

																?>
																<option value="<?= $result['BarangayID']; ?>"><?= $result['BarangayName']; ?></option>
																<?php } ?>
																</select> 
														</div>
															<div class="form-group col-md-12">
																<label>Street/Purok*</label>
																<input class="form-control" name="SpecificAddress" placeholder="144 Purok Sampaguita" type="textbox"/>
															</div>
														</div>
														</div>
														</div>
														</div>
										
										<div id = "sector_div">
										<div class="col-lg-6">
											<div class="panel panel-success" id="accordion">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
												<div class="panel-heading">Sectors</div>
												</a>
												<div class="panel-body panel-collapse collapse in" id="collapseFive">                           
														<?php

                             							 $results = $db_handle->runFetch("SELECT * FROM sector");
               
                          								foreach ($results as $result) {
                                
														?>
														<div class="checkbox col-md-4">
															<label class="checkbox-inline"  style ="display: visible !important;"><input value="<?= $result['SectorID']; ?>"  data-toggle="checkbox" type="checkbox" name='sector'><?= $result['Name']; ?></label>
														</div>
														<?php } ?>
													</div>
													</div>
                      								
										      
													</div>

													</div>
                            <input type="submit" class="btn btn-info" value="Submit">
                     						 		</form>
													</div>
                        </div>
                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
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
	
    <style type="text/css">
    	
    		#home_based_div{
    			display: none;
    		}
    		#displayHead{
    			display: none;
    		}

    </style>

  </body>
</html>