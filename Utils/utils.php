<?php

function isOfType($variable, $type){
    return gettype($variable) === $type;
}
function array_check($array, $size){

    if (!isOfType($array,"array"))
    {
        echo "Invalid type Expected array and recieved".gettype($array);
        return false;
    }
    if (count($array) != $size){
        echo "Invalid number of paramters Expected ".$size." and recieved ".count($array);
        return false;
    }

    return true;
}
