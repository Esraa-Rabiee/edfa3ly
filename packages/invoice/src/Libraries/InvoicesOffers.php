<?php

namespace Invoice\Libraries;

use Invoice\Entities\Item;

class InvoicesOffers
{
    private float $offerDiscount = 0.0;
    private array $offerDisplay = [];

    private array $offers = [
        Item::JACKET_TYPE => [
            'offerPercentage' => .5,
            'offerFormat' => '50%',
        ],
        Item::SHOES_TYPE => [
            'offerPercentage' => .1,
            'offerFormat' => '10%',
        ],
        'shippingOffer' => [
            'offerPercentage' => 10,
            'offerFormat' => '10$',
        ]
    ];

    /**
     * @param array $items
     * @return array|void
     */
    public function execute(array $items)
    {
        if (empty($items)) {
            return;
        }
        $this->calculateShoesOffer($items);
        $this->calculateTwoTopsWithJacketOffer($items);
        if (count($items) >= 2) {
            $this->offerDiscount += $this->offers['shippingOffer']['offerPercentage'];
            $this->offerDisplay[] = sprintf(
                "%s off %s: %s",
                $this->offers['shippingOffer']['offerFormat'],
                'shipping',
                $this->offers['shippingOffer']['offerFormat']
            );
        }

        return [
            'discount' => $this->offerDiscount,
            'discountDisplay' => $this->offerDisplay
        ];
    }

    /**
     * @param array $items
     */
    private function calculateShoesOffer(array $items)
    {
        $shoesPrice = 0.0;
        $shoesCount = 0;
        foreach ($items as $item) {
            if ($item->getType() == Item::SHOES_TYPE) {
                $shoesPrice = $item->getPrice();
                $shoesCount++;
            }
        }

        if ($shoesCount) {
            $discountAmount = $shoesCount * $shoesPrice * $this->offers[Item::SHOES_TYPE]['offerPercentage'];
            $this->offerDiscount += $discountAmount;
            $this->offerDisplay[] = sprintf(
                "%s off %s: {$discountAmount}",
                $this->offers[Item::SHOES_TYPE]['offerFormat'],
                Item::SHOES_TYPE
            );
        }
    }

    /**
     * @param array $items
     */
    private function calculateTwoTopsWithJacketOffer(array $items)
    {
        $jacketPrice = 0.0;
        $jacketCount = 0;
        $topCount = 0;
        foreach ($items as $item) {
            if (in_array($item->getType(), [Item::TSHIRT_TYPE, Item::BLOUSE_TYPE])) {
                $jacketPrice = $item->getPrice();
                $topCount++;
            }
            if ($item->getType() == Item::JACKET_TYPE) {
                $jacketPrice = $item->getPrice();
                $jacketCount++;
            }
        }

        if ($jacketCount && $topCount >= 2) {
            $discountAmount = $jacketPrice * $jacketCount * $this->offers[Item::JACKET_TYPE]['offerPercentage'];
            $this->offerDiscount += $discountAmount;
            $this->offerDisplay[] = sprintf(
                "%s off %s: {$discountAmount}",
                $this->offers[Item::JACKET_TYPE]['offerFormat'],
                Item::JACKET_TYPE
            );
        }
    }
}
