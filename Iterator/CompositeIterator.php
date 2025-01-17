<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "\utils.php");
require_once "ArrayIterator.php";

class CompositeIterator implements IIterator
{
    private $stack;

    public function __construct()
    {
        $this->stack = new Stack();
    }

    public function SetIterable($iterable)
    {

        $this->stack->push($iterable);

    }

    public function HasNext()
    {
        if ($this->stack->isEmpty())
        {
            return false;
        }
        else
        {
            $iterator = $this->stack->peek();
            if ($iterator->HasNext())
            {
                return true;
            }
            else
            {
                $this->stack->pop();
                return $this->HasNext();
            }


        }
    }
    public function Next()
    {
        if($this->HasNext()) 
        {
            $ParentIterator = $this->stack->peek();
            $Child = $ParentIterator->Next();
            $ChildIterator = $Child::getArrayIterator();
            $ChildIterator->SetIterable($Child->getChildren());
            $this->SetIterable($ChildIterator);
            
            return $Child;
        }


        else {return null;}
    }
    
}