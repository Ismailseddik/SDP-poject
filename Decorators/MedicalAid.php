<?php

class MedicalAid extends AidTypeDecorator
{
    private string $medicineType;

    public function __construct(array $data, string $medicineType) {
        parent::__construct($data); // Initialize the base properties from AidTypeModel
        $this->medicineType = $medicineType;
    }

    public function provideAidType(): int {
        echo "Providing medical aid with medicine type: " . $this->medicineType;
        return 2; // Example return value
    }
}