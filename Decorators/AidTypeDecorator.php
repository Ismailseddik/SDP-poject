<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . "/Models/pmaAidTypeModel.php");
// require_once "../Models/pmaAidTypeModel.php";
abstract class AidTypeDecorator 
{
    protected pmaAidTypeModel $ref;
    // public function __construct(array $data) {
    //     parent::__construct($data); // Calling the parent constructor
    // }

    // public function provideAidType(): array
    // {
    //     return [];
    // } // returns the aid type: 1 for financial, 2 for medical, 3 for operational

    public abstract function WrapAidType();
}