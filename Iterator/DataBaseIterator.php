<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "\utils.php");
class DataBaseIterator implements IIterator
{
    private $data;
    private $index;

    public function __construct()
    {

    }

    public function SetIterable($data)
    {
        // or !CheckType($data->fetch_all(MYSQLI_ASSOC),'array')
        if(!CheckType($data,'object'))
        {
            echo 'Problem in Recived Datatype';
            echo 'Unable to create Iterator';

            return;
        }

        $this->data = $data->fetch_all(MYSQLI_ASSOC);
        $this->Reset();
    }

    public function HasNext()
    {
        return $this->index < count($this->data);
    }
    public function Next()
    {
        if($this->HasNext()) 
        {
            $element = $this->data[$this->index];
            $this->index = $this->index+1;
            return $element;
        }


        else {return null;}
    }
    public function Reset()
    {
        $this->index = 0;
        return;
    }
    
}