<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Http\Controllers\CityController;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\WithoutMiddleware;
use Database\Factories;
use App\Models\Cityzone;
use Tests\TestCase;

// use ReflectionClass;
// use PHPUnit\Framework\TestCase;

/**
 * @backupGlobals disabled
 */
/**
 * Test cases for class Dice
 */
class CityControllerTest extends TestCase
{
    use WithoutMiddleware;
    // use DatabaseMigrations;
    /**
     * Construct object to be used in tests.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new CityController();
        $this->assertInstanceOf("App\Http\Controllers\CityController", $this->controller);
    }

    public function testShowOneCity()
    {
        $response = $this->call('POST', '/sparkapi/v1/cities', [
            'city' => '90w3u90rehio',
            'X' => 0.25,
            'Y' => 0.25,
            'radius' => 0.05
        ]);
        $this->assertEquals(201, $response->status());

        $city = new Cityzone();
        $id = $city::where('city', '90w3u90rehio')->get('id')->first();

        $response = $this->call('GET', '/sparkapi/v1/cities/' . $id->id);

        $this->assertEquals(200, $response->status());
    }

    public function testShowAllCities()
    {
        $response = $this->call('GET', '/sparkapi/v1/cities');
        $this->assertEquals(200, $response->status());
    }

    public function testPostCity()
    {
        $response = $this->call('POST', '/sparkapi/v1/cities', [
            'city' => 'Stad',
            'X' => 0.25,
            'Y' => 0.25,
            'radius' => 0.05
        ]);
        $this->assertEquals(201, $response->status());
    }

    public function testPutCity()
    {
        $response = $this->call('POST', '/sparkapi/v1/cities', [
            'city' => '90w3u90rehio',
            'X' => 0.25,
            'Y' => 0.25,
            'radius' => 0.05
        ]);
        $this->assertEquals(201, $response->status());

        $city = new Cityzone();
        $id = $city::where('city', '90w3u90rehio')->get('id')->first();

        $response = $this->call('PUT', '/sparkapi/v1/cities/' . $id->id, [
            'city' => 'Stad',
            'X' => 0.25,
            'Y' => 0.25,
            'radius' => 0.05
        ]);
        $this->assertEquals(200, $response->status());
    }
}
