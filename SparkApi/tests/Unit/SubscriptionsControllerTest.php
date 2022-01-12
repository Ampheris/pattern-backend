<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Http\Controllers\SubscriptionsController;
use Laravel\Lumen\Testing\WithoutMiddleware;
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
    use WithoutMiddleware;

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

    public function testShowAllSubscriptions()
    {
        $response = $this->call('GET', '/sparkapi/v1/subscriptions');
        $this->assertEquals(200, $response->status());
    }
}
