<?php
abstract class AidTypeDecorator extends aidTypeModel
{

    public function __construct(array $data) {
        parent::__construct($data); // Calling the parent constructor
    }

    abstract public function provideAidType(): int; // returns the aid type: 1 for financial, 2 for medical, 3 for operational
}