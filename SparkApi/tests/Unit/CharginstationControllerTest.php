<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Http\Controllers\ChargingStationsController;
use App\Models\Chargingstation;
use Tests\TestCase;

// use ReflectionClass;
// use PHPUnit\Framework\TestCase;

/**
 * @backupGlobals disabled
 */
/**
 * Test cases for class Dice
 */
class ChargingStationsControllerTest extends TestCase
{

    // use DatabaseMigrations;
    /**
     * Construct object to be used in tests.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new ChargingStationsController();
        $this->assertInstanceOf("App\Http\Controllers\ChargingStationsController", $this->controller);
    }

    public function testShowOneChargingStation()
    {
        // $response = $this->call('GET', '/sparkapi/v1/chargingstations/1');

        // $this->assertEquals(200, $response->status());
    }

    public function testShowAllChargingstations()
    {
        $response = $this->call('GET', '/sparkapi/v1/chargingstations');
        $this->assertEquals(200, $response->status());
    }

    public function testPostChargingStations()
    {
        $response = $this->call('POST', '/sparkapi/v1/chargingstations', [
            'name' => 'y978q2t34hu9weg',
            'X' => 0.25,
            'Y' => 0.25,
            'radius' => 0.05
        ]);
        $this->assertEquals(201, $response->status());
        $bike = new Chargingstation();
        $bike::where('name', 'y978q2t34hu9weg')->delete();
    }

    public function testPutChargingStations()
    {
        $response = $this->call('POST', '/sparkapi/v1/chargingstations', [
            'name' => 'y978q2t34hu9weg',
            'X' => 0.25,
            'Y' => 0.25,
            'radius' => 0.05
        ]);
        $this->assertEquals(201, $response->status());
        $bike = new Chargingstation();
        $id = $bike::where('name', 'y978q2t34hu9weg')->get('id')->first();

        $response = $this->call('PUT', '/sparkapi/v1/chargingstations/'.$id->id, [
            'name' => 'kljaweioawg',
            'X' => 0.25,
            'Y' => 0.25,
            'radius' => 0.05
        ]);
        $this->assertEquals(200, $response->status());
    }
}
