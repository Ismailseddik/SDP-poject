<?php
require_once '../interfaces/DonorTierStrategy.php';

class GoldTierStrategy implements DonorTierStrategy
{
    public function getBenefits(): string
    {
        return "Priority support, 10% discount on donations, exclusive events";
    }

    public function getDiscountRate(): float
    {
        return 0.10; // 10% discount
    }

    public function getTierName(): string
    {
        return "Gold";
    }
}