<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Http\Controllers\BikeHistoryController;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Database\Factories;
use App\Models\Bikelog;
use DateTime;
use Tests\TestCase;

// use ReflectionClass;
// use PHPUnit\Framework\TestCase;

/**
 * @backupGlobals disabled
 */
/**
 * Test cases for class Dice
 */
class BikeHistoryControllerTest extends TestCase
{

    /**
     * Check that the showAll action returns json.
     * @runInSeparateProcess
     */
    public function testShowAll()
    {
        $response = $this->call('GET', '/sparkapi/v1/bikehistory/bike');
        $response->assertStatus(200);
    }

        /**
     * Check that the showOneBikesHistory action returns 200 response.
     * @runInSeparateProcess
     */
    public function testShowOneBikesHistory()
    {
        $response = $this->call('GET', '/sparkapi/v1/bikehistory/bike/1');
        $response->assertStatus(200);
    }

    public function testShowAllBikeHistory()
    {
        $response = $this->call('GET', '/sparkapi/v1/bikehistory');

        $this->assertEquals(200, $response->status());
    }

    public function testShowOneBikesHistoryUser()
    {
        $response = $this->call('GET', '/sparkapi/v1/bikehistory/user/1');

        $this->assertEquals(200, $response->status());
    }

    public function testShowUsersActiveBikeHistory()
    {
        $response = $this->call('GET', '/sparkapi/v1/bikehistory');

        $this->assertEquals(200, $response->status());
    }
    public function testBikeHistoryHistoryId()
    {
        $response = $this->call('GET', '/sparkapi/v1/bikehistory/1');

        $this->assertEquals(200, $response->status());
    }

    public function testPostBikeHistory()
    {
        $response = $this->call('POST', '/sparkapi/v1/bikehistory/start', [
            'customer_id' => 0,
            'bike_id' => 0
        ]);
        $this->assertEquals(201, $response->status());

        $log = new Bikelog();
        $id = $log::where('customer_id', 0)->get('id')->first();
        $log::where('id', $id)->delete();
    }

    public function testPutBikeHistory()
    {
        $customer_id = 0;
        $response = $this->call('POST', '/sparkapi/v1/bikehistory/start', [
            'customer_id' => $customer_id,
            'bike_id' => 0
        ]);

        $this->assertEquals(201, $response->status());

        $response = $this->call('POST', '/sparkapi/v1/bikehistory/stop/' . $customer_id, [
            'customer_id' => $customer_id,
        ]);

        $this->assertEquals(200, $response->status());

        $log = new Bikelog();
        $id = $log::where('customer_id', $customer_id)->get('id')->first();
        $log::where('id', $id)->delete();
    }
}
