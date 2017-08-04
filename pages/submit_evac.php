<?php
  session_start();
  require_once("dbcontroller.php");
$db_handle = new DBController();

//$previous = $_SERVER['HTTP_REFERRER'];





  $ename = $_POST['Ename'];
  $barangay = $_POST['selected_barangay'];
  $evac_type = $_POST['evac_type'];
  $manager = $_POST['manager'];
  $contact = $_POST['contact'];
  $address = $_POST['address'];
  echo "<script type='text/javascript'>alert('True!');
                             
                              </script>";

   
      $query = $db_handle->runUpdate("INSERT INTO `evacuation_centers`(`EvacName`, `EvacAddress`, `EvacType`, `EvacManager`, `EvacManagerContact`, `SpecificAddress`) VALUES ('".$ename."','".$barangay."','".$evac_type."','".$manager."','".$contact."','".$address."')");
    
                  if($db_handle->getUpdateStatus()) 
                  {
                      echo "<script type='text/javascript'>alert('Add Succesful1!');
                      
                      </script>";
                  }

                  
?>