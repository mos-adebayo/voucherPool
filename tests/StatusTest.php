<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class StatusTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStatusData()
    {
        $this->seeInDatabase('status', ['name' => 'Used']);

    }
}
