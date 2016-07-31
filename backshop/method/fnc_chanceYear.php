<?php

function changeDate($dateTemp){
    $d="";
    $m="";
    $y="";
    $temp="";

    $temp=(explode("-",$dateTemp));
    $d=$temp[2];
    $m=$temp[1];
    $y=$temp[0]+543;


    $dmy="$d-$m-$y";
    return $dmy;
}

function changeDateSwap($dateTemp){
    $d="";
    $m="";
    $y="";
    $temp="";

    $temp=(explode("-",$dateTemp));
    $y=$temp[2]-543;
    $m=$temp[1];
    $d=$temp[0];


    $ymd="$y-$m-$d";
    return $ymd;
}
?>

