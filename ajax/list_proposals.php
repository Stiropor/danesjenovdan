<?php

/* Connects to database and returns list of proposals in ajax string.
 *
 * usage:
 * list_proposals.php?no=number_of_proposals&sortby=date|importance
 *
 * if no arguments are given defaults are taken. no=10, sortby=date
 */


require("../config/config.php");

// Checking and setting defaults if necessary.
if(isset($_REQUEST['no'])){
    $number=$_REQUEST['no'];
}
else {
    $number=10;
}

if(!isset($_REQUEST['sortby']) || $_REQUEST['sortby']=="timestamp"){
    $sortby="timestamp";
}
else {
    $sortby="importance";
}

if(!isset($_REQUEST['order']) || $_REQUEST['order']=="desc"){
    $order="desc";
}
else {
    $order="asc";
}

$query="select * from proposal order by ".$sortby ." ".$order." limit
".$number.";";

//echo $query;
    $array=array();;
if ($result = $db->query($query)) {
    while($obj=$result->fetch_object()){

    array_push($array,$obj);
}
    echo json_encode($array);    
    $result->close();
}

$db->close();

?>
