<?php
// /interfaces/DonorTierStrategy.php
interface DonorTierStrategy
{
    public function getBenefits(): string;
    public function getDiscountRate(): float;
    public function getTierName(): string;
}
