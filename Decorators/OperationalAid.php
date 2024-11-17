<?php

class OperationalAid extends AidTypeDecorator
{


    public function __construct($ref) {
        $this->ref = $ref;

    }


    public function provideAidType(): array {
        $arr = $this->ref->provideAidType();
        array_push($arr,3);
        return $arr; // Example return value
    }

}