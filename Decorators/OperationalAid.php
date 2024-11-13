<?php

class OperationalAid extends AidTypeDecorator
{
    private string $operationType;
    private Doctor $assignedDoctor;

    public function __construct(array $data, string $operationType, Doctor $assignedDoctor) {
        parent::__construct($data); // Initialize the base properties from AidTypeModel
        $this->operationType = $operationType;
        $this->assignedDoctor = $assignedDoctor;
    }


    public function provideAidType(): int {
        echo "Providing operational aid with operation type: " . $this->operationType;
        echo " and assigned doctor: " . $this->assignedDoctor->getFirstName();
        return 3; // Example return value
    }

}