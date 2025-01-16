<?php

function CheckType($variable , $ExpectedType){
    return gettype($variable) === $ExpectedType;
}