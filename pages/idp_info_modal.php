 <?php
require_once("dbcontroller.php");
$db_handle = new DBController();
$idp_id = $_GET['id'];

$idps = $db_handle->runFetch("SELECT * FROM `idp` WHERE idp.IDP_ID = ".$idp_id);
if(!empty($idps)) {
    foreach ($idps as $idp) {
?> 

<tr>
    <td>
        <!-- The Modal -->
        <div id="myModal<?php echo($idp['IDP_ID']) ?>" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span id = "<?php echo($idp['IDP_ID']) ?>" class="close" onclick="close_modal(this.id)">&times;</span>
                <h2>
                    <?php echo($idp['Fname']) ?>&nbsp<?php echo($idp['Mname']) ?>&nbsp<?php echo($idp['Lname']) ?>
                    <span><h5><sup>Personal Information</sup></h5></span>
                </h2>

            </div>
            <div class="modal-body">
        <?php
        $id = $idp['IDP_ID'];

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
                        <td style="border-top: 0px solid black"><h5><b>Relation to Head</b></h5></td>

                    </tr>
                    <tr>
                        <td style="border-top: 0px solid black"><?php echo $result1['Bdate']; ?></td>
                        <td style="border-top: 0px solid black"><?php echo $result1['Age']; ?></td>
                        <td style="border-top: 0px solid black"><?php echo ($result1['Gender'] == '1') ? 'Male' : 'Female'; ?></td>
                    <?php

                    $maritalStatus = $result1['MaritalStatus'];
                    if ($maritalStatus == "1"){
                        $maritalStatus = "Single";
                    } else if($maritalStatus == "2"){
                        $maritalStatus = "Married";
                    } else if($maritalStatus == "3"){
                        $maritalStatus = "Annulled";
                    } else if($maritalStatus == "4"){
                        $maritalStatus = "Widowed";
                    }
                    ?>
                        <td style="border-top: 0px solid black"><?php echo $maritalStatus ?></td>
                        <td style="border-top: 0px solid black"><?php echo $result1['RelationToHead']; ?></td>
                    </tr>
                </table>

                <br>
                <br>
                <br>
                <br>
                <br>
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
                        <td style="border-top: 0px solid black">
                <?php
                $b_id =$result1['Origin_Barangay'];
                $barangays = $db_handle->runFetch("SELECT * FROM barangay WHERE BarangayID = $b_id");
                foreach ($barangays as $barangay) {
                    $c_id =$barangay['City_CityID'];
                    echo $barangay['BarangayName'];
                }
                ?>
                        </td>
                        <td style="border-top: 0px solid black">
                <?php
                $citys = $db_handle->runFetch("SELECT * FROM city_mun WHERE City_Mun_ID = $c_id");
                foreach ($citys as $city) {
                    $p_id = $city['PROVINCE_ProvinceID'];
                    echo $city['City_Mun_Name'];
                }
                ?>
                        </td>
                        <td style="border-top: 0px solid black"></td>
                        <td style="border-top: 0px solid black">
                <?php
                $provinces = $db_handle->runFetch("SELECT * FROM province WHERE ProvinceID = $p_id");
                foreach ($provinces as $province) {
                    echo $province['ProvinceName'];
                }
                ?>
                        </td>
                    </tr>
                </table>
                <br>
                <br>
                <br>
                <br>
                <br>
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
                <br>
                <br>
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
                <br>
                <br>
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
                }
            }
            ?>
                </div>
                <div class='modal-footer'>
                    <a id= '<?php echo($idp['IDP_ID']) ?>' class ='btn btn-primary btn-fill' style ='color:white' onclick='printDiv(this.id)'> PRINT
                    </a>
                </div>
            </div>
        </div>
    </td>
</tr>
<?php
    }
}
?>