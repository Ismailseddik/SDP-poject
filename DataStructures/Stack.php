<?php

class Stack {
    private $stack = [];

    public function push($item) {
        array_push($this->stack,$item);
    }

    public function pop() {
        if ($this->isEmpty()) {
            return false;
        }
        return array_pop($this->stack);
    }

    public function peek() {
        if ($this->isEmpty()) {
            return false;
        }
        return $this->stack[$this->size()-1]; 
    }

    public function isEmpty() {
        return empty($this->stack);
    }

    public function size() {
        return count($this->stack);
    }
}