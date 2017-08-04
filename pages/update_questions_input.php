<?php
session_start();
require_once("dbcontroller.php");

$arr_result = $_POST['arr_result'];
//$arr_result= $string_result;
//echo count($arr_result);

 $_SESSION['arr'] = $arr_result;
// $count = count($arr_result)/intval($_POST['count']);
// $count1 = intval($_POST['count']);
// $arr_result_count = count($arr_result);
// $new_arr = array();
// $arr_count =0;
// $checks =0;
//     for($arr_count1 = 0; $arr_count1!= $arr_result_count-1; $arr_count1++ )
//     {

//             $new_arr[$arr_count][$arr_count1 -$checks] = $arr_result[$arr_count1];
//             if( ($arr_count1+1)% $count == 0)
//             {   
//                 $checks = $arr_count1+1;
//                 $arr_count++;
//             }
        
//     }

// echo $new_arr[1][0];
//$html_id = $_GET['html_id'];
//echo $range;
//$html_form = addslashes($_GET['html_form']);
//echo $html_form;
//$question = $_POST['question_upd'];
$db_handle = new DBController();
//$previous = $_POST['previous_page'];


for($count = 0; $count!=count($arr_result); $count++)

{
   //$_SESSION['trial1'] ="".$arr_result[1][1]. "".$count;
     

      if($arr_result[$count][1] == "text" || $arr_result[$count][1] == "textarea" )

      {

            $html_forms = $db_handle->runFetch("SELECT * FROM `html_form` WHERE `HTML_FORM_TYPE` = '".$arr_result[$count][1]."' AND `HTML_FORM_INPUT_QUANTITY` = 1");
            if(!empty($html_forms))
             { 
                foreach ($html_forms as $html_form)
                 { 
                        $question = $db_handle->runUpdate("UPDATE `questions` SET `HTML_FORM_HTML_FORM_ID` = '".$html_form['HTML_FORM_ID']."' WHERE `questions`.`QuestionsID` = ".$arr_result[$count][0]);
                 }
            }

      }
      else{
            $html_forms = $db_handle->runFetch("SELECT * FROM `html_form` WHERE `HTML_FORM_TYPE` = '".$arr_result[$count][1]."' AND `HTML_FORM_INPUT_QUANTITY` =". $arr_result[$count][2]);
            if(!empty($html_forms))
             { 
                foreach ($html_forms as $html_form)
                 { 
                        $question = $db_handle->runUpdate("UPDATE `questions` SET `HTML_FORM_HTML_FORM_ID` = '".$html_form['HTML_FORM_ID']."' WHERE `questions`.`QuestionsID` = ".$arr_result[$count][0]);
                 }
            }
    }
}

    // $question = $db_handle->runUpdate("UPDATE `questions` SET `HTML_FORM_HTML_FORM_ID` = '".$html_id."' WHERE `questions`.`QuestionsID` = ".$id);

          $form_id =  $_SESSION['form_id'] ;
       
//echo $form_id;
        $form_name =  $_SESSION['form_name'];
        
       //echo $form_name;
    if($db_handle->getUpdateStatus()) {
       // $_SESSION['range'] = $range;
  
    }

?>
