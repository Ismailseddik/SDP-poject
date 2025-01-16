<?php

interface IIterator
{
    public function HasNext();
    public function Next();
    public function Reset();
    public function SetIterable($iterable);
}