<?php include ('check_credentials.php'); ?>
<?php 
$ul_list = "active";
include ('head.php');
include ('footer.php');
include ('sidebar.php');
include ('navbar.php');
require_once("dbcontroller.php");
$db_handle = new DBController();
$_SESSION['disaster_id'] = 1;
?>



        <div class="main-panel">
        <style type="text/css">
        .modal {
            display: block; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: auto; /* Location of the box */
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
            width: 70%;

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
                                <!--<p class="category"> <i class="fa fa-square-o"></i> IDPs will be listed here</p> <br>-->
                                <a class='btn btn-success btn-fill' href='cswd.php'><i class='pe-7s-add-user'></i> Add New IDP</a>
                                </div>
                                    <div class="panel-body">
                                    <table id="idp_list" class="table table-bordered table-advance table-hover ">
                                    <?php
                                    $idps = $db_handle->runFetch("SELECT DAFAC_DAFAC_SN, IDP_ID, CONCAT(Lname, ', ', Fname, ' ', Mname) AS IDPName, Gender, Age, COALESCE(MIN(j.INTAKE_ANSWERS_ID), 0) AS intake_answersID FROM `idp` i  LEFT JOIN intake_answers j on i.IDP_ID = j.IDP_IDP_ID GROUP BY i.IDP_ID, IDPName ORDER BY IDPName ASC");
                                    if(!empty($idps)) { 
                                    ?>
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Gender</th>
                                                <th>Age</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Gender</th>
                                                <th>Age</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        <?php
                                        foreach ($idps as $idp) {
                                        echo '<tr>
                                            <td align="left">' . $idp['IDPName'] .'</td>
                                            <td align="left">';
                                            echo(($idp['Gender'] == 1) ? 'Male' : 'Female');
                                            echo '</td>
                                            <td align="left">' . $idp['Age'] . '</td>
                                            <td align="left">';
                                            $idp_age_group = ($idp['Age'] < 18) ? 2 : 1;
                                            if($idp['intake_answersID'] == 0) {
                                                echo '
                                                <button class="btn btn-primary btn-fill" id="'.$idp['IDP_ID'].'" onClick ="load_modal(this.id)"><i class="pe-7s-info"></i> View</button>
                                                <a class="btn btn-warning btn-fill" href="deletecswd.php?id="'.$idp['IDP_ID'].'"><i class="pe-7s-delete-user"></i> Update </a>';
                                            } else {
                                                echo '
                                                <button class="btn btn-primary btn-fill" id="'.$idp['IDP_ID'].'" onClick ="load_modal(this.id)"><i class="pe-7s-info"></i> View</button>
                                                <a class="btn btn-warning btn-fill" href="deletecswd.php?id="'.$idp['IDP_ID'].'"><i class="pe-7s-delete-user"></i> Update </a>';
                                            }
                                            echo '
                                            </td>
                                        </tr>
                                        ';
                                        }
                                        }?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- page end-->
                                <div id="modal-container">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container section end -->
        <!-- javascripts -->
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- nice scroll -->
        <script src="js/jquery.scrollTo.min.js"></script>
        <script src="js/jquery.nicescroll.js" type="text/javascript"></script><!--custom script for all page-->
        <script>

            window.load_modal = function(clicked_id) {
                $("#modal-container").load("idp_info_modal.php?id="+clicked_id, function() {
                    show_modal(clicked_id);
                });

            }

            function show_modal(clicked_id) {
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

            $(document).ready(function() {
                $('#idp_list').DataTable();
            } );
        </script>
        <!-- datatables -->
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script src="js/jquery-1.12.4.js"></script>