<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "\utils.php");
class SelfRefrenceIterator implements IIterator
{
    private $data;
    // private $id;

    public function __construct()
    {

    }

    public function SetIterable($data)
    {
        $this->data = $data; 
    }

    public function HasNext()
    {
        return $this->data->getParentID() != 0;
    }
    public function Next()
    {
        if($this->HasNext()) 
        {
            return $this->data->getParentID();
        }

        else {return null;}
    }
    


    
}