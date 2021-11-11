<?php

namespace Invoice\Libraries;

use Exception;
use Illuminate\Validation\ValidationException;
use Invoice\Dto\Invoice;
use Invoice\Dto\InvoiceItemDto;
use Invoice\Repositories\ItemRepositoryInterface;

class CreateInvoiceSumLibrary
{
    private ItemRepositoryInterface $itemRepository;
    private InvoicesOffers $invoiceOffers;

    /**
     * @param ItemRepositoryInterface $itemRepository
     * @param InvoicesOffers $invoiceOffers
     */
    public function __construct(
        ItemRepositoryInterface $itemRepository,
        InvoicesOffers          $invoiceOffers
    )
    {
        $this->itemRepository = $itemRepository;
        $this->invoiceOffers = $invoiceOffers;
    }

    /**
     * execute invoice sum
     *
     * @param InvoiceItemDto $invoiceItemDto
     *
     * @return Invoice
     *
     * @throws ValidationException
     */
    public function execute(InvoiceItemDto $invoiceItemDto): Invoice
    {
        $itemsTypes = $invoiceItemDto->getItems();
        if (is_null($itemsTypes)) {
            throw ValidationException::withMessages(["items can't be null"]);
        }

        $invoiceItemsData = $this->itemRepository->findBy([
            'type' => $itemsTypes
        ]);

        if (empty($invoiceItemsData)) {
            throw new Exception("failed");
        }

        $items = $this->prepareItems($itemsTypes, collect($invoiceItemsData));

        $itemsSubTotalWithShipping = $this->calculateShippingAndSubtotals($items);

        $discount = $this->invoiceOffers->execute($items);

        $subTotal = $itemsSubTotalWithShipping['subTotal'];
        $subShipping = $itemsSubTotalWithShipping['shipping'];
        $vat = $itemsSubTotalWithShipping['subTotal'] * Invoice::VAT_PRECENTAGE;
        $invoice = (new Invoice())->setSubtotal($subTotal)
            ->setShipping($subShipping)
            ->setVAT($vat);
        $total = $subTotal + $subShipping + $vat;
        if (isset($discount['discountDisplay'])) {
            $invoice->setDiscounts($discount['discountDisplay']);
            $total = $total - $discount['discount'];
        }
        $invoice->setTotal($total);
        return $invoice;

    }

    private function prepareItems(array $itemsTypes, $itemsObjects): array
    {
        $items = [];
        foreach ($itemsTypes as $itemType) {
            $items[] = $itemsObjects->first(function ($item) use ($itemType) {
                return $item->getType() == $itemType;
            });
        }
        return $items;
    }

    /**
     * @param array $items
     *
     * @return array
     */
    private function calculateShippingAndSubtotals(array $items): array
    {
        $subTotal = 0.0;
        $shipping = 0.0;
        foreach ($items as $item) {
            $subTotal += $item->getPrice();
            $shipping += ($item->getWeight() * Invoice::RATE_CALCULATION_FACTOR * $item->getRate());
        }
        return [
            'subTotal' => $subTotal,
            'shipping' => $shipping
        ];
    }
}
