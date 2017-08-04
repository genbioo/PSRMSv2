<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
$previous = $_SERVER['HTTP_REFERER'];
$html_forms = $db_handle->runFetch("SELECT * FROM `html_form` WHERE 1");

//$_POST['submitButton'] and $_POST['checkbox'] will mess up code below. These values ar included in the previous submit if: the questions' HTML_FORMS is not null in the database  && the user will submit the form layout without changing anything. It is safer to unset these variables before populating $post below
unset($_POST['submitButton']);  //
unset($_POST['checkbox']);      //

$post =  array_values($_POST);  //$_POST assoc to numeric array; contains form type, quantity alternately
$post_len = count($post);
$q_ids = $_SESSION['q_ids'];    //array of question ids
$q_ids_len = count($q_ids);     //q_ids entry count/ array length
$q_html_form = array();         //array for html_form ids to be used in query
$query = "";                    //sql query
$outputArray = array();         //SPL** entry search output (contains form_id, form type, quantity from HTML_FORMS table)

//converting $post array to a 2d array that contains [form type, quantity] per entry
for($i = 0; $i < $post_len; $i += 2) {
    $q_html_form[] = array($post[$i], $post[$i+1]);
}

//**SPL method for searching associative array by $key => $value. Not sure how it works but it works. lol------------------------
//method found here: https://stackoverflow.com/questions/1019076/how-to-search-by-key-value-in-a-multidimensional-array-in-php
$array_iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($html_forms));
for($j = 0; $j < $q_ids_len; $j++) {
    foreach ($array_iterator as $sub) {
        $subArray = $array_iterator->getSubIterator();
        if (($subArray['HTML_FORM_TYPE'] === $q_html_form[$j][0]) && ($subArray['HTML_FORM_INPUT_QUANTITY'] === $q_html_form[$j][1] || $subArray['HTML_FORM_INPUT_QUANTITY'] === null) ) {
            //$outputArray[] = iterator_to_array($subArray);
            $outputArray[] = array_values(iterator_to_array($subArray));
        }
    }
}
//----------------------------------------------------------------------------------------------------------------------------

for($k = 0; $k < $q_ids_len; $k++) {
    $query .= "UPDATE `questions` SET `HTML_FORM_HTML_FORM_ID` = '".$outputArray[$k][0]."' WHERE `questions`.`QuestionsID` = '".$q_ids[$k]."';";
}

$db_handle->runUpdate($query);

if($db_handle->getUpdateStatus()) {
    echo "<script type='text/javascript'>alert('Layout saved!');
    location='".$previous."';
    </script>";
}
?>