<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class OfferTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Get Recipients test .
     *
     * @return void
     */
    public function testGetOffers()
    {
        $response = $this->call('GET', 'offers');

        $this->assertEquals(200, $response->status());

    }
    /**
     * Create Offer successfully .
     *
     * @return void
     */
    public function testCreateOffer()
    {
             $request = $this->call('POST', '/offer', ['name' => 'Offer Name', 'description' => 'Offer Description', 'fixed_discount' => 30, 'expiry_date' => '2020-10-10']);
            $this->assertEquals(201, $request->status());
    }
    /**
     * Prevent Create Offer With invalid Payload .
     *
     * @return void
     */
    public function testCreateOfferInvalid()
    {
//        No name & Wrong expiry date
            $request = $this->call('POST', '/offer', ['description' => 'Offer Description', 'fixed_discount' => 30, 'expiry_date' => 'kkk']);
            $this->assertEquals(400, $request->status());

//            Past date supplied
        $request = $this->call('POST', '/offer', ['name' => 'Offer Name', 'description' => 'Offer Description', 'fixed_discount' => 30, 'expiry_date' => '2000-10-10']);
            $this->assertEquals(400, $request->status());
    }
}
