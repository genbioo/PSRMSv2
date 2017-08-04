<html>
    <head>
        <?php
        session_start();
        include("head.php");
        if(isset($_SESSION["userID"])) {
            header( "Location: dashboard.php" );
        }
        require_once("dbcontroller.php");
        include("css_include.php");
        $db_handle = new DBController();
        ?>
    </head>
    <body>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="panel panel-default panel-info" id="login-panel">
                            <div class="panel-heading">
                                <h4 class="text-center">PSRMS</h4>
                            </div>
                                <div class="panel-body">
                                    
                                    <form action="login.php" method="post"> 
                                        <label for="agencyID">User - Agency:</label>
                                        <select class="form-control" id="agencyID" name="agencyID">
                                            <?php
                                            $users = $db_handle->runFetch("SELECT * FROM `user` JOIN agency ON agency.AgencyID = user.AGENCY_AgencyID ORDER BY Lname ");
                                            if(!empty($users)) {
                                                foreach ($users as $user) {
                                                    echo ("<option value='".$user['UserID']."'>".$user['Lname'].", ".$user['Fname']." ".$user['Mname']." - ".$user['AgencyName']."</option>");
                                                    $userID = $user['UserID'];
                                                }
                                            }
                                            ?>
                                        </select>
                                        <br>
                                        <input type="hidden" name="userID" value="<?php echo($userID); ?>">
                                        <input type="submit" class="btn btn-info btn-fill btn-lg center-block" id="login-btn" value="Login">
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>
            </div> 
    </body>
</html>