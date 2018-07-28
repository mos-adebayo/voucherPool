<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RecipientTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Get Recipients test .
     *
     * @return void
     */
    public function testGetRecipients()
    {
        $response = $this->call('GET', 'recipients');

        $this->assertEquals(200, $response->status());

    }
    /**
     * Create Recipient successfully .
     *
     * @return void
     */
    public function testCreateRecipient()
    {
             $request = $this->call('POST', '/recipient', ['name' => 'Adeola Shina', 'email' => 'adeola.shina@gxmail.com']);
            $this->assertEquals(201, $request->status());
    }
    /**
     * Create Recipient successfully With invalid Payload .
     *
     * @return void
     */
    public function testCreateRecipientInvalid()
    {
             $request = $this->call('POST', '/recipient', ['email' => 'adeola.shina@gxmail.com']);
            $this->assertEquals(400, $request->status());
             $request = $this->call('POST', '/recipient', ['name' => 'Adeola Shina']);
            $this->assertEquals(400, $request->status());
             $request = $this->call('POST', '/recipient', ['email'=> 'adeolas', 'name' => 'Adeola Shina']);
            $this->assertEquals(400, $request->status());
    }
}
