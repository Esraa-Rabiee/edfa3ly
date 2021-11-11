<?php

namespace App\Representations\JsonApi\Schemas\PackagesSchema;

use Neomerx\JsonApi\Schema\SchemaProvider;

class InvoiceSchema extends SchemaProvider
{

    protected $resourceType = 'invoice';

    /**
     * @param object $resource
     * @return string
     */
    public function getId($resource): string
    {
        return $resource->getId();
    }

    /**
     * @param object $resource
     * @return array
     */
    public function getAttributes($resource): array
    {
        return [
            'subtotal' => $resource->getSubtotal(),
            'shipping' => $resource->getShipping(),
            'discounts' => $resource->getDiscounts(),
            'VAT' => $resource->getVAT(),
            'total' => $resource->getTotal()
        ];
    }
}
