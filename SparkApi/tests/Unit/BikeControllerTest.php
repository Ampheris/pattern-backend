<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Http\Controllers\BikeController;
use App\Models\Bike;
use Tests\TestCase;

// use ReflectionClass;
// use PHPUnit\Framework\TestCase;

/**
 * @backupGlobals disabled
 */
/**
 * Test cases for class Dice
 */
class BikeControllerTest extends TestCase
{

    // use DatabaseMigrations;
    /**
     * Construct object to be used in tests.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new BikeController();
        $this->assertInstanceOf("App\Http\Controllers\BikeController", $this->controller);
    }

    /**
     * Check that the showOneBikesHistory action returns json.
     * @runInSeparateProcess
     */
    public function testShowOneBike()
    {
        $response = $this->call('GET', '/sparkapi/v1/bikes/1');

        $this->assertEquals(200, $response->status());
    }

    public function testShowAllBikes()
    {
        $response = $this->call('GET', '/sparkapi/v1/bikes');
        $this->assertEquals(200, $response->status());
    }

    public function testPostBike()
    {
        $response = $this->call('POST', '/sparkapi/v1/bikes', [
            'status' => 'available',
            'name' => 'kljaweioawg',
            'battery' => 100,
            'velocity' => 0,
            'X' => 0.25,
            'Y' => 0.25
        ]);
        $this->assertEquals(201, $response->status());
        $bike = new Bike();
        $bike::where('name', 'kljaweioawg')->delete();
    }

    // public function testPostBikeNotUnique()
    // {
    //     $response = $this->call('POST', '/sparkapi/v1/bikes', [
    //         'status' => 'available',
    //         'name' => 'kljaweioawg',
    //         'battery' => 100,
    //         'velocity' => 0,
    //         'X' => 0.25,
    //         'Y' => 0.25
    //     ]);
    //     $this->assertEquals(201, $response->status());

    //     $response = $this->call('POST', '/sparkapi/v1/bikes', [
    //         'status' => 'available',
    //         'name' => 'kljaweioawg',
    //         'battery' => 100,
    //         'velocity' => 0,
    //         'X' => 0.25,
    //         'Y' => 0.25
    //     ]);
    //     $this->assertEquals(500, $response->status());


    //     $bike = new Bike();
    //     $bike::where('name', 'kljaweioawg')->delete();
    // }

    public function testPutBike()
    {
        $response = $this->call('POST', '/sparkapi/v1/bikes', [
            'status' => 'available',
            'name' => 'kljaweioawg',
            'battery' => 100,
            'velocity' => 0,
            'X' => 0.25,
            'Y' => 0.25
        ]);
        $this->assertEquals(201, $response->status());
        $bike = new Bike();
        $id = $bike::where('name', 'kljaweioawg')->get('id')->first();

        $response = $this->call('PUT', '/sparkapi/v1/bikes/'. $id->id, [
            'status' => 'available',
            'name' => 'gwaoiewajlk',
            'battery' => 100,
            'velocity' => 0,
            'X' => 0.25,
            'Y' => 0.25
        ]);
        $this->assertEquals(200, $response->status());
    }

    public function testDeleteBike()
    {
        $response = $this->call('POST', '/sparkapi/v1/bikes', [
            'status' => 'available',
            'name' => 'kljaweioawg',
            'battery' => 100,
            'velocity' => 0,
            'X' => 0.25,
            'Y' => 0.25
        ]);
        $this->assertEquals(201, $response->status());
        $bike = new Bike();
        $id = $bike::where('name', 'kljaweioawg')->get('id')->first();
        $response = $this->call('DELETE', '/sparkapi/v1/bikes/'. $id->id);

        $this->assertEquals(200, $response->status());
    }
}
