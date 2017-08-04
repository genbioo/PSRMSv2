<?php include ('check_credentials.php'); ?>
<?php include ('head.php'); ?>

<?php $ul_evac ="active"; include ('sidebar.php'); ?>

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
                                <h4 class="title">Evacuation Centers </h4> <br>



                                <p class="category"> <i class="fa fa-square-o"></i> Evacuation Centers will be listed here</p> <br>
                                <a class='btn btn-success' href='add_evacuation.php'><i class='pe-7s-add-user'></i> Add New Evcuation Center</a>
                                
                            </div>


              <div class="panel-body">
        
        <table class="table table-bordered table-advance table-hover ">
           <tbody>
            <tr>
             <th><i class="icon_mobile"></i> Evacuation Center No.</th>
             <th><i class="icon_profile"></i> Evacuation Center Name</th>
             <th><i class="icon_profile"></i>Evacuation Center Address</th>
             <th><i class="icon_pin_alt"></i> Evacuation Center Type</th>
             <th><i class="icon_pin_alt"></i> Evacuation Center Manager</th>
             <th><i class="icon_calendar"></i> Evacuation Center Contact</th>
             <th><i class="icon_calendar"></i> Evacuation Center Specific Address</th>
             
            </tr>
            <?php
            

            $evacs = $db_handle->runFetch("SELECT * FROM `evacuation_centers` WHERE 1");
          if(!empty($evacs)) {
                     foreach ($evacs as $evac) {
                echo //Display table 
                
                '<tr>
                <td>'.$evac['EvacuationCentersID'].'</td>
                <td>'.$evac['EvacName'].'</td>';
                $b_id =$evac['EvacAddress'];
                $barangays = $db_handle->runFetch("SELECT * FROM `barangay` WHERE BarangayID = $b_id ");
          if(!empty($barangays)) {
                     foreach ($barangays as $barangay) {
                      $evac_barangay = $barangay['BarangayName'];  
                        echo '<td>' . $barangay['BarangayName'].'</td>';
                     }}

                $gender = $evac['EvacType'];
                if ($gender=="1"){
                echo ("<td>Evacuation'Center</td>");
                }
                else if($gender=="2"){
                echo ("<td>Home Based</td>");
                };
                
                echo '
                
                <td>'.$evac['EvacManager'].'</td>
                <td>'.$evac['EvacManagerContact'].'</td>
                <td>'.$evac['SpecificAddress'].'</td>';
                
                
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
