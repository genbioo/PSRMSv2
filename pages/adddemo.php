<?php
  session_start();
  require_once("dbcontroller.php");
$db_handle = new DBController();

//$previous = $_SERVER['HTTP_REFERRER'];
  $lname = $_POST['Lname'];
  $fname = $_POST['Fname'];
  $mname = $_POST['Mname'];
  $bdate = $_POST['Bdate'];
  $dateadded = date('Y-m-d H:i:s');
  $age = $_POST['Age'];
  $gender = $_POST['Gender'];
  $marital_status = $_POST['MaritalStatus'];
    $education  = $_POST['education'];
  $occupation = $_POST['occupation'];
  $phonenum = $_POST['PhoneNum'];
  $email = $_POST['Email'];
  $othercontact = $_POST['OtherContact'];
  if(isset($_POST['sector'])){
  $sector = $_POST['sector'];}
  $uid = $_SESSION['userID'];
  
  $datetaken = date('Y-m-d H:i:s');
  $evacid = $_POST['EvacName'];
  $evactype = $_POST['EvacType'];
  $specificaddress1 = $_POST['SpecificAddress1'];
  $barangay1 = $_POST['barangay1'];
  $barangay2 = $_POST['barangay2'];  

$serial_no = $_POST['serial_no'];


  $province = $_POST['province'];
  $city_mun = $_POST['city_mun'];
  //$district = $_POST['District'];

  $specificaddress = $_POST['SpecificAddress'];
  
  $relation = $_POST['relation'];
  $selected_head = $_POST['selected_head'];
  $relationOther = $_POST['relationOther'];

	$name = $fname . ' ' . $mname . ' ' . $lname;

    if($relation == 1)
    {

      $query = $db_handle->runUpdate("INSERT INTO dafac_no(Name, serial_no) VALUES('".$name."', '".$serial_no."')");
    
                  if($db_handle->getUpdateStatus()) 
                  {
                      echo "<script type='text/javascript'>alert('Add Succesful!');
                      
                      </script>";
                  }

                    $fetchLast = $db_handle->runFetch("SELECT * FROM dafac_no ORDER BY DAFAC_SN DESC LIMIT 1");
               
                    foreach ($fetchLast as $lastId) 
                    {
                      $dafac_no = $lastId['DAFAC_SN'];
                    }


                     $query = $db_handle->runUpdate("INSERT INTO `idp`(`DAFAC_DAFAC_SN`, `RelationToHead`, `Lname`, `Fname`, `Mname`, `Bdate`, `Age`, `Gender`, `Education`, `MaritalStatus`, `PhoneNum`, `Origin_Barangay`, `Email`, `EvacuationCenters_EvacuationCentersID`, `DateTaken`, `USER_UserID`, `Occupation`,  `OtherContact`, `SpecificAddress`) VALUES ('".$dafac_no."','".$relation."','".$lname."','".$fname."','".$mname."','".$bdate."','".$age."','".$gender."','".$education."','".$marital_status."','".$phonenum."','".$barangay1."','".$email."','".$evacid."','".$datetaken."','".$uid."','".$occupation."','".$othercontact."','".$specificaddress."')");

     }
    else if($relation >=2)
        {
        

            

                  $dafac_no = intval($selected_head); 
                    $HOFs =  $db_handle->runFetch("SELECT * FROM IDP WHERE DAFAC_DAFAC_SN = $dafac_no AND RelationToHead = 1");
                  foreach ($HOFs as $HOF) {


                            $phonenum = $HOF['PhoneNum'];
                            $barangay1 = $HOF['Origin_Barangay'];
                            $email = $HOF['Email'];
                            $evacid = $HOF['EvacuationCenters_EvacuationCentersID'];
                            $occupation = $HOF['Occupation'];
                            $othercontact = $HOF['OtherContact'];
                            $specificaddress = $HOF['SpecificAddress'];
                          }
                
                 
                  $query = $db_handle->runUpdate("INSERT INTO `idp`(`DAFAC_DAFAC_SN`, `RelationToHead`, `Lname`, `Fname`, `Mname`, `Bdate`, `Age`, `Gender`, `Education`, `MaritalStatus`, `PhoneNum`, `Origin_Barangay`, `Email`, `EvacuationCenters_EvacuationCentersID`, `DateTaken`, `USER_UserID`, `Occupation`,  `OtherContact`, `SpecificAddress`) VALUES ('".$dafac_no."','".$relation."','".$lname."','".$fname."','".$mname."','".$bdate."','".$age."','".$gender."','".$education."','".$marital_status."','".$phonenum."','".$barangay1."','".$email."','".$evacid."','".$datetaken."','".$uid."','".$occupation."','".$othercontact."','".$specificaddress."')");

                        if($db_handle->getUpdateStatus()) 
                        {
                              echo "<script type='text/javascript'>alert('Add Succesful2!');
                             
                              </script>";
                          }



                          $fetchLast = $db_handle->runFetch("SELECT * FROM dafac_no ORDER BY DAFAC_SN DESC LIMIT 1");
                                         
                          foreach ($fetchLast as $lastId) {


                            $dafac_no = $lastId['DAFAC_SN'];
                          }
                
               
        }
      

  
 

 echo "<script> window.location.href='list.php';</script>";
 echo "<script>alert('Details successfully added') </script>";

?>