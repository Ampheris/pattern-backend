<?php

use App\Models\Bike;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bikes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('status');
            $table->integer('battery');
            $table->integer('velocity');
            $table->float('X');
            $table->float('Y');
            $table->timestamps();
        });
        $this->migrationCreate();
    }

    public function migrationCreate()
        {
            $faker = Faker\Factory::create();
            for ($i = 0; $i < 10; $i++) {
                $bike = new Bike();
                $bike->name = "Spark-" . $faker->firstName($gender = 'male'|'female');
                $bike->status = "available";
                $bike->battery = 100;
                $bike->velocity = 0;
                $bike->X = rand(55, 68);
                $bike->Y = rand(12, 18);
                $bike->save();
            }

            $bike = new Bike();
            $bike->name = "Spark-" . $faker->firstName($gender = 'male'|'female');
            $bike->status = "available";
            $bike->battery = 29;
            $bike->velocity = 0;
            $bike->X = rand(55, 68);
            $bike->Y = rand(12, 18);
            $bike->save();

            $bike = new Bike();
            $bike->name = "Spark-" . $faker->firstName($gender = 'male'|'female');
            $bike->status = "unavailable";
            $bike->battery = 29;
            $bike->velocity = 0;
            $bike->X = rand(55, 68);
            $bike->Y = rand(12, 18);
            $bike->save();

            $bike = new Bike();
            $bike->name = "Spark-" . $faker->firstName($gender = 'male'|'female');
            $bike->status = "service";
            $bike->battery = 100;
            $bike->velocity = 0;
            $bike->X = rand(55, 68);
            $bike->Y = rand(12, 18);
            $bike->save();
        }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bikes');
    }
}
