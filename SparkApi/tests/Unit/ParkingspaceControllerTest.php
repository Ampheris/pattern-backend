<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Http\Controllers\ParkingSpacesController;
use Laravel\Lumen\Testing\WithoutMiddleware;
use App\Models\Parkingspace;
use Tests\TestCase;

// use ReflectionClass;
// use PHPUnit\Framework\TestCase;

/**
 * @backupGlobals disabled
 */
/**
 * Test cases for class Dice
 */
class ParkingSpacesControllerTest extends TestCase
{
    use WithoutMiddleware;
    // use DatabaseMigrations;
    /**
     * Construct object to be used in tests.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new ParkingSpacesController();
        $this->assertInstanceOf("App\Http\Controllers\ParkingSpacesController", $this->controller);
    }

    public function testShowOneParkingSpace()
    {
        $response = $this->call('POST', '/sparkapi/v1/parkingspaces', [
            'name' => 'y978q2t34hu9weg',
            'X' => 0.25,
            'Y' => 0.25,
            'radius' => 0.05
        ]);
        $this->assertEquals(201, $response->status());

        $bike = new Parkingspace();
        $id = $bike::where('name', 'y978q2t34hu9weg')->get('id')->first();

        $response = $this->call('GET', '/sparkapi/v1/parkingspaces/' . $id->id);

        $this->assertEquals(200, $response->status());
    }

    public function testShowAllParkingSpaces()
    {
        $response = $this->call('GET', '/sparkapi/v1/parkingspaces');
        $this->assertEquals(200, $response->status());
    }

    public function testPostParkingSpaces()
    {
        $response = $this->call('POST', '/sparkapi/v1/parkingspaces', [
            'name' => 'y978q2t34hu9weg',
            'X' => 0.25,
            'Y' => 0.25,
            'radius' => 0.05
        ]);
        $this->assertEquals(201, $response->status());
        $bike = new Parkingspace();
        $bike::where('name', 'y978q2t34hu9weg')->delete();
    }

    public function testPutParkingSpaces()
    {
        $response = $this->call('POST', '/sparkapi/v1/parkingspaces', [
            'name' => 'y978q2t34hu9weg',
            'X' => 0.25,
            'Y' => 0.25,
            'radius' => 0.05
        ]);
        $this->assertEquals(201, $response->status());
        $bike = new Parkingspace();
        $id = $bike::where('name', 'y978q2t34hu9weg')->get('id')->first();

        $response = $this->call('PUT', '/sparkapi/v1/parkingspaces/' . $id->id, [
            'name' => 'kljaweioawg',
            'X' => 0.25,
            'Y' => 0.25,
            'radius' => 0.05
        ]);
        $this->assertEquals(200, $response->status());
    }
}
