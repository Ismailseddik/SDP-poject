<?php

class SilverTierStrategy implements DonorTierStrategy
{
    public function getBenefits(): string
    {
        return "Standard support, 5% discount on donations";
    }

    public function getDiscountRate(): float
    {
        return 0.05; // 5% discount
    }

    public function getTierName(): string
    {
        return "Silver";
    }
}
