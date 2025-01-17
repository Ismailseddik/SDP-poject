<?php

interface IIterator
{
    public function HasNext();
    public function Next();
    public function SetIterable($iterable);
}