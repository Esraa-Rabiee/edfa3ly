<?php
namespace Invoice\Test;

use Tests\TestCase;

class InvoiceApiTest extends TestCase
{

    public function testRequiredFieldsForApi()
    {
        $this->json('POST', 'api/invoice', ['Accept' => 'application/vnd.api+json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "items" => ["The items field is required."]
                ]
            ]);
    }

    public function testInvalidItemSentWillThrowException()
    {
        $this->json('POST', 'api/invoice',['items' => 'xx'], ['Accept' => 'application/vnd.api+json'])
            ->assertStatus(500);
    }

    public function testApiCreatedResourceSuccessful()
    {
        $this->json('POST', 'api/invoice', ['items' => ['Blouse']], ['Accept' => 'application/vnd.api+json'])
            ->assertStatus(200);
    }
}
