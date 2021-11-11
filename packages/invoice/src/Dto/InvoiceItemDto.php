<?php

namespace Invoice\Dto;
use Illuminate\Support\Arr;

class InvoiceItemDto
{
    private array $attributesBag;

    /**
     * @param array $attributesBag
     */
    public function __construct(array $attributesBag)
    {
        $this->attributesBag = $attributesBag;
    }

    /**
     * get invoice items data
     *
     * @return array|null
     */
    public function getItems(): ?array
    {
        return Arr::get($this->attributesBag, 'items', null);
    }
}
