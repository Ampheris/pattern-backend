<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Http\Controllers\BikeHistoryController;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;

use Database\Factories;
use App\Models\Bikelog;
use App\Models\User;
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
    use DatabaseMigrations;
    /**
     * Construct object to be used in tests.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->bikelog = Bikelog::factory()->create();
        $this->controller = new BikeHistoryController();
        $this->assertInstanceOf("App\Http\Controllers\BikeHistoryController", $this->controller);
    }

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
        $this->seeInDatabase('bikelogs', ['bike_id' => '1']);

        $response = $this->call('GET', '/sparkapi/v1/bikehistory/bike/1');
        $response->assertStatus(200);
    }

    /**
     * Check that the showOneUsersBikeHistory action returns 200 response.
     * @runInSeparateProcess
     */
    public function testOneUsersBikeHistory()
    {
        $response = $this->call('GET', '/sparkapi/v1/bikehistory/user/1');
        $response->assertStatus(200);
    }

    /**
     * Check that the showOneUsersActiveBikeHistory action returns 200 response.
     * @runInSeparateProcess
     */
    public function testShowOneUsersActiveBikeHistory()
    {
        $response = $this->call('GET', '/sparkapi/v1/bikehistory/user/active/1');
        $response->assertStatus(200);
    }

    /**
     * Check that the start action returns 200 response.
     * @runInSeparateProcess
     */
    public function testStart()
    {
        $user = User::factory()->create();
        $this->seeInDatabase('users', ['id' => '1']);

        $this->json('POST', '/sparkapi/v1/bikehistory/start', ['customer_id' => '1'])
         ->seeJson([
            'created' => true,
         ]);
    }

}
