
<?php
include ('check_credentials.php');
include ('head.php');
?>

<?php $ul_index = "active"; $ul_forms = ""; $ul_idp =""; include ('sidebar.php'); ?>

    <div class="main-panel">
        
<?php include ('navbar.php'); ?>

<?php include ('footer.php'); ?>
<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
  //$id = $_GET['id'];

?>
  <form method="POST" action="submit_evac.php">
       <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        

              <!-- page start-->
              <div class="row">
                <div class="col-lg-12">
                   
					    <div class="row">
							<div class="col-lg-6">
                                <div class="panel panel-success">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    <div class="panel-heading">Evacuation Center Information</div>
									</a>
                                        <div class="panel-body panel-collapse collapse in" id="collapseOne">
                                            <div class="form-group col-md-12">
                                                <label>Evacuation Center Name<span class="required">*</span></label>
                                                <input class="form-control" id = 'Ename' name='Ename' placeholder="Enter Evacuation Center name" required>
                                            </div>

												<div class="form-group col-md-12">
                                                
												<label>Select Barangay:</label>
												<select class="form-control" id= 'selected_barangay' name='selected_barangay' >
												<option>  <label>Select Barangay<span class="required">*</span></label> </option>
													<?php

                         								 $results = $db_handle->runFetch("SELECT * FROM `barangay` ORDER BY BarangayName ASC;");
               
                             							 foreach ($results as $result) {
                              
													?>
														<option value='<?= $result['BarangayID']; ?>' ><?= $result['BarangayName']; ?></option>
													<?php } ?>
													
												</select>
												
											</div>
										  
											<div class="form-group col-md-12">
												<label>Evacuation Center Type<span class="required">*</span></label>
												
														<select class="form-control" name='evac_type' >
																<option value="1">Evacuation Center</option>
																<option value="2">Home Based</option>										 
														</select>
														
													</div>

                          <div class="form-group col-md-12">
                                                <label>Evacuation Center Manager</label>
                                                <input class="form-control" name="manager" placeholder="Enter Manager" >
                                            </div>
                          <div class="form-group col-md-12">

                                                                  <label>Evacuation Center Contact Number</label>
                                                <input class="form-control" name="contact" placeholder="Enter Contact Number" >
                                            </div>
                      <div class="form-group col-md-12">

                                                                  <label>Evacuation Center Specific Address</label>
                                                <input class="form-control" name="address" placeholder="Enter Address" >
                                            </div>
                                      
													<!--/.col-md-6-->
												</div>

												<!--/.row-->
											</div>
                      <input type="submit" class="btn btn-info" value="Submit">
                                    </form>
                                            
                                           
                                        </div>
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
	<script type="text/javascript">
        function ShowHideDiv() {
           // var  relation= document.getElementById("relation");
            //var other = document.getElementById("other");
            var education = document.getElementById("education");
            var elementary1 = document.getElementById("elementary1");
            var highschool1 = document.getElementById("highschool1");
            var college1 = document.getElementById("college1");


            //other.style.display = relation.value == "others" ? "block" : "none";
            elementary1.style.display = education.value == "elementary" ? "block" : "none";
            highschool1.style.display = education.value == "highschool" ? "block" : "none";
            college1.style.display = education.value == "college" ? "block" : "none";
			
			
		


			}


     
			  $(function () {
      $("#relation").change(function() {
          var val = $(this).val();
          	var target = document.getElementById('displayHead');
			var target2 = document.getElementById('target2');
			
        if(val === "1")
        {
         
        		var serial_no = document.getElementById("serial_no_div");
	       		serial_no.style = 'display:block';
	       		target.style = 'display:none';
				target2.style = 'display:none';
        }
	       else
	       {
	       		var serial_no = document.getElementById("serial_no_div");
	       		serial_no.style = 'display:none';
	       		target.style = 'display:block';
				target2.style = 'display:block';
				document.getElementById("serial_no").required = false;
	       }
  });
});
        

          $(function () {
      $("#EvacType").change(function() {
          var val = $(this).val();
        if(val === "1")
        {
         

        var home_based_div = document.getElementById("home_based_div");
	       		home_based_div.style = 'display:none';

        }
        if(val === "2")
        {
        	var home_based_div = document.getElementById("home_based_div");
	       		home_based_div.style = 'display:block';
        }
  });
});




      
    </script>
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
