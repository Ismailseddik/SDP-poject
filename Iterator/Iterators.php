<?php

require_once "IIterator.php";
require_once "ArrayIterator.php";
require_once "DataBaseIterator.php";
require_once "SelfRefrenceIterator.php";

class Iterators 
{
    private static IIterator $ArrayIterator;
    private static IIterator $DataBaseIterator;
    private static IIterator $SelfRefrenceIterator;

    private static function intialize_ArrayIterator()
    {
        self::$ArrayIterator = new CustomArrayIterator(); 
    }

    public static function getArrayIterator(): IIterator {
        if (!isset(self::$ArrayIterator)) {
            self::intialize_ArrayIterator();
        }
        return self::$ArrayIterator;
    } 

    private static function intialize_DBIterator()
    {
        self::$DataBaseIterator = new DatabaseIterator(); 
    }

    public static function getDBIterator(): IIterator {
        if (!isset(self::$DBIterator)) {
            self::intialize_DBIterator();
        }
        return self::$DataBaseIterator;
    } 

    private static function intialize_SelfRefrenceIterator()
    {
        self::$SelfRefrenceIterator = new SelfRefrenceIterator(); 
    }

    public static function getSelfRefrenceIterator(): IIterator {
        if (!isset(self::$SelfRefrenceIterator)) {
            self::intialize_SelfRefrenceIterator();
        }
        return self::$SelfRefrenceIterator;
    } 


}
