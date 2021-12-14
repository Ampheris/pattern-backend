<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Http\Controllers\SubscriptionsController;
use App\Models\Subscription;
use Tests\TestCase;

// use ReflectionClass;
// use PHPUnit\Framework\TestCase;

/**
 * @backupGlobals disabled
 */
/**
 * Test cases for class Dice
 */
class SubscriptionsControllerTest extends TestCase
{

    // use DatabaseMigrations;
    /**
     * Construct object to be used in tests.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new SubscriptionsController();
        $this->assertInstanceOf("App\Http\Controllers\SubscriptionsController", $this->controller);
    }

    public function testShowOneSubscription()
    {
        $response = $this->call('POST', '/sparkapi/v1/subscriptions', [
            'start_date' => '2021-01-01',
            'renewal_date' => '2021-02-01',
            'customer_id' => 200,
            'cancelation_date' => '2021-01-05',
            'price' => 53276
        ]);
        $this->assertEquals(201, $response->status());

        $sub = new Subscription();
        $id = $sub::where('customer_id', 200)->get('id')->first();

        $response = $this->call('GET', '/sparkapi/v1/subscriptions/' . $id->id);

        $this->assertEquals(200, $response->status());
        $sub::where('customer_id', 200)->delete();
    }

    public function testShowAllSubscriptions()
    {
        $response = $this->call('GET', '/sparkapi/v1/subscriptions');
        $this->assertEquals(200, $response->status());
    }

    public function testPostSubscriptions()
    {
        $response = $this->call('POST', '/sparkapi/v1/subscriptions', [
            'start_date' => '2021-01-01',
            'renewal_date' => '2021-02-01',
            'customer_id' => 200,
            'cancelation_date' => '2021-01-05',
            'price' => 53276
        ]);
        $this->assertEquals(201, $response->status());
        $sub = new Subscription();
        $sub::where('price', 53276)->delete();
    }

    public function testPutSubscriptions()
    {
        $response = $this->call('POST', '/sparkapi/v1/subscriptions', [
            'start_date' => '2021-01-01',
            'renewal_date' => '2021-02-01',
            'customer_id' => 200,
            'cancelation_date' => '2021-01-05',
            'price' => 53276
        ]);
        $this->assertEquals(201, $response->status());
        $sub = new Subscription();
        $id = $sub::where('customer_id', 200)->get('id')->first();

        $response = $this->call('PUT', '/sparkapi/v1/subscriptions/stop/' . $id->id, [
            'start_date' => '2021-01-01',
            'renewal_date' => '2021-02-01',
            'customer_id' => 200,
            'cancelation_date' => '2021-01-05',
            'price' => 53276
        ]);
        $this->assertEquals(200, $response->status());
        $sub::where('customer_id', 200)->delete();

    }
}
