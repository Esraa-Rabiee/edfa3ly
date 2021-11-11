<?php

namespace Invoice\Test;

use Invoice\Dto\Invoice;
use Invoice\Dto\InvoiceItemDto;
use Invoice\Entities\Item;
use Invoice\Libraries\CreateInvoiceSumLibrary;
use Invoice\Libraries\InvoicesOffers;
use Invoice\Repositories\ItemRepository;
use Mockery;
use Tests\TestCase;

class CreateInvoiceSumLibraryTest extends TestCase
{
    private $itemMock;
    private $itemRepositoryMock;
    private $invoicesOffersMock;
    private $createInvoiceSumLibraryPartialMock;
    private $invoiceItemDto;
    private $invoiceMovk;

    public function setUp(): void
    {
        parent::setUp();
        // Mock entities
        $this->itemMock = Mockery::mock(Item::class);
        $this->invoiceMock = Mockery::mock(Invoice::class);

        //Mock Dtos
        $this->invoiceItemDto = Mockery::mock(InvoiceItemDto::class, ['items' => ['Blouse']]);

        // Mock Repos
        $this->itemRepositoryMock = $this->getMockBuilder(ItemRepository::class)
            ->disableOriginalConstructor()->getMock();

        // Mock libraries
        $this->invoicesOffersMock = Mockery::mock(
            InvoicesOffers::class
        );

        $this->createInvoiceSumLibraryPartialMock = Mockery::mock(
            CreateInvoiceSumLibrary::class,
            [
                $this->itemRepositoryMock,
                $this->invoicesOffersMock
            ]
        )->makePartial()
            ->shouldAllowMockingProtectedMethods();

        //prepare item entity
        $this->itemMock->shouldReceive('getPrice')->andReturn(.55);
        $this->itemMock->shouldReceive('getWeight')->andReturn(.5);
        $this->itemMock->shouldReceive('getRate')->andReturn(2);
        $this->itemMock->shouldReceive('getType');
    }

    public function testThatExecuteWillReturnInvoiceObject()
    {
        $this->invoiceItemDto->shouldReceive('getItems')->once()->andReturn(['Blouse']);
        $this->itemRepositoryMock->expects($this->once())->method('findBy')
            ->willReturn([$this->itemMock]);
        $this->createInvoiceSumLibraryPartialMock->shouldReceive('calculateShippingAndSubtotals')
            ->andReturn([
                    'subTotal' => .55,
                    'shipping' => .02
                ]
            );
        $this->invoicesOffersMock->shouldReceive('execute');
        $this->assertInstanceOf(Invoice::class, $this->runExecute());

    }


    private function runExecute()
    {
        return $this->createInvoiceSumLibraryPartialMock->execute(
            $this->invoiceItemDto
        );
    }
}
