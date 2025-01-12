<?php

class MedicalAid extends AidTypeDecorator
{
    // private string $medicineType;

    public function __construct($ref) {
        $this->ref = $ref;
    }

    public function provideAidType(): array {
        $arr = $this->ref->provideAidType();
        array_push($arr,2);
        return $arr; // Example return value
    }
}