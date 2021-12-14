<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Http\Controllers\OrdersController;
use App\Models\Order;
use Tests\TestCase;

// use ReflectionClass;
// use PHPUnit\Framework\TestCase;

/**
 * @backupGlobals disabled
 */
/**
 * Test cases for class Dice
 */
class OrdersControllerTest extends TestCase
{

    // use DatabaseMigrations;
    /**
     * Construct object to be used in tests.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new OrdersController();
        $this->assertInstanceOf("App\Http\Controllers\OrdersController", $this->controller);
    }

    public function testShowOneOrder()
    {
        $response = $this->call('POST', '/sparkapi/v1/orders', [
            'customer_id' => 100,
            'total_price' => 5234,
            'subscription' => 0,
            'bikehistory_id' => 235
        ]);
        $this->assertEquals(201, $response->status());

        $bike = new Order();
        $id = $bike::where('total_price', 5234)->get('id')->first();

        $response = $this->call('GET', '/sparkapi/v1/orders/' . $id->id);

        $this->assertEquals(200, $response->status());
    }

    public function testShowAllOrders()
    {
        $response = $this->call('GET', '/sparkapi/v1/orders');
        $this->assertEquals(200, $response->status());
    }

    public function testPostPrders()
    {
        $response = $this->call('POST', '/sparkapi/v1/orders', [
            'customer_id' => 100,
            'total_price' => 5234,
            'subscription' => 0,
            'bikehistory_id' => 235
        ]);
        $this->assertEquals(201, $response->status());
        $bike = new Order();
        $bike::where('total_price', 5234)->delete();
    }
}
