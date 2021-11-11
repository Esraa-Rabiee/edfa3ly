<?php

namespace App\Http\Controllers;

use App\Representations\JsonApi\Schemas\PackagesSchema\InvoiceSchema;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\ValidationException;
use Invoice\Dto\Invoice;
use Invoice\Dto\InvoiceItemDto;
use Invoice\Libraries\CreateInvoiceSumLibrary;
use Neomerx\JsonApi\Contracts\Http\ResponsesInterface;
use Neomerx\JsonApi\Encoder\Encoder;

class InvoiceController extends BaseController
{
    protected ResponsesInterface $response;


    /**
     * @throws ValidationException
     */
    public function postInvoiceTotal(Request $request, CreateInvoiceSumLibrary $createInvoiceSumLibrary)
    {
        $invoices = $createInvoiceSumLibrary->execute(new InvoiceItemDto($request->get('data')['attributes']));

        $encoder = Encoder::instance([
            Invoice::class => InvoiceSchema::class,
        ]);

        return $encoder->encodeData($invoices);
    }
}
