<?php
/**
 * Created by IntelliJ IDEA.
 * User: Max
 * Date: 5/29/2019
 * Time: 6:21 PM
 */

namespace Tests\Invoices;


use Tests\BaseTest;
use Faker;
class UpdateInvoiceTest extends BaseTest
{
    public function testUpdateInvoices()
    {
        $this->setUp();
        $faker = Faker\Factory::create();
        try {

            $params = [
                'accounting_id' => '192',
                'type' => 'ACCREC',
                'date' => '2020-03-03',
                'due_date' => '2020-03-03',
                'contact' => '23',
                'invoice_reference' => '678745983232',
                'discount_amount' => 100,
                'deposit_amount' => 200,
                'deposit_account' => 13,
                'sync_token' => 23,
                'invoice_data' => [
                    [
                        'description' => 'Consulting services as agreed (20% off standard rate)',
                        'quantity' => '10',
                        'unit_amount' => '100.00',
                        'discount_rate' => '20',
                        'amount' => 1000,
                        'code' => 200,
                        'tax_id' => 10,
                        'account_id' => 10,
                        'item_id' => 15
                    ]
                ],
                'address' => [
                    'type' => 'BILLING',
                    'address_line_1' => $faker->streetAddress,
                    'city' => $faker->city,
                    'postal_code' => $faker->postcode,
                    'country' => $faker->country
                ]
            ];

            $response = $this->gateway->updateInvoice($params)->send();
            if ($response->isSuccessful()) {
                var_dump($response->getInvoices());
            } else {
                var_dump($response->getErrorMessage());
            }
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
        }
    }
}