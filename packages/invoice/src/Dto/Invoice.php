<?php

namespace Invoice\Dto;

class Invoice
{
    public const VAT_PRECENTAGE = .14;
    public const RATE_CALCULATION_FACTOR = 10;
    private string $id;
    private float $subtotal;
    private float $shipping;
    private float $VAT;
    private array $discounts = [];
    private float $total = 0.0;

    /**
     * @return string
     */
    public function getId(): string
    {
        return uniqid();
    }

    /**
     * @return float
     */
    public function getSubtotal(): float
    {
        return $this->subtotal;
    }

    /**
     * @param float $subtotal
     * @return Invoice
     */
    public function setSubtotal(float $subtotal): Invoice
    {
        $this->subtotal = $subtotal;
        return $this;
    }

    /**
     * @return float
     */
    public function getShipping(): float
    {
        return $this->shipping;
    }

    /**
     * @param float $shipping
     * @return Invoice
     */
    public function setShipping(float $shipping): Invoice
    {
        $this->shipping = $shipping;
        return $this;
    }

    /**
     * @return float
     */
    public function getVAT(): float
    {
        return $this->VAT;
    }

    /**
     * @param float $VAT
     * @return Invoice
     */
    public function setVAT(float $VAT): Invoice
    {
        $this->VAT = $VAT;
        return $this;
    }

    /**
     * @return array
     */
    public function getDiscounts(): array
    {
        return $this->discounts;
    }

    /**
     * @param array $discounts
     */
    public function setDiscounts(array $discounts): void
    {
        $this->discounts = $discounts;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }

    /**
     * @param float $total
     */
    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

}
