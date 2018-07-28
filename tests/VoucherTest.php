<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class VoucherTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Get Vouchers test .
     *
     * @return void
     */
    public function testGetVouchers()
    {
        $response = $this->call('GET', 'vouchers');

        $this->assertEquals(200, $response->status());

    }
    /**
     * Validate Invalid Voucher  .
     *
     * @return void
     */
    public function testValidateVoucherInvalid()
    {
         $request = $this->call('POST', '/vouchers/validate', ['email' => 'mos.adebayo@gmail.com', 'voucher' => 'voucher']);
          $this->assertEquals(400, $request->status());
    }
}
