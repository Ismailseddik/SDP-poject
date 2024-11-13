<?php
require_once '../interfaces/DonorTierStrategy.php';

class PlatinumTierStrategy implements DonorTierStrategy
{
    public function getBenefits(): string
    {
        return "24/7 support, 20% discount on donations, VIP events, free merchandise";
    }

    public function getDiscountRate(): float
    {
        return 0.20; // 20% discount
    }

    public function getTierName(): string
    {
        return "Platinum";
    }
}