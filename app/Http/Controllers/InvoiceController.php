<?php

namespace App\Http\Controllers;

use App\Representations\JsonApi\Schemas\PackagesSchema\InvoiceSchema;
use Illuminate\Foundation\Validation\ValidatesRequests;
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
    use ValidatesRequests;
    protected ResponsesInterface $response;


    /**
     * @throws ValidationException
     */
    public function postInvoiceTotal(Request $request, CreateInvoiceSumLibrary $createInvoiceSumLibrary)
    {
        $this->validate($request, [
            'items' => 'required',
        ]);
        $invoices = $createInvoiceSumLibrary->execute(new InvoiceItemDto($request->all()));

        $encoder = Encoder::instance([
            Invoice::class => InvoiceSchema::class,
        ]);

        return $encoder->encodeData($invoices);
    }
}
