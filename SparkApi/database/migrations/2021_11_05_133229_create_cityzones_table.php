<?php

use App\Models\Cityzone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityzonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cityzones', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->float('X');
            $table->float('Y');
            $table->float('radius');
            $table->timestamps();
        });
        $this->migrationCreate();
    }
    
    public function migrationCreate()
        {
            $city = new Cityzone();
            $city->city = "Stockholm";
            $city->X = 59.3251172;
            $city->Y = 18.0710935;
            $city->radius = 18/110;
            $city->save();

            $city = new Cityzone();
            $city->city = "Malmö";
            $city->X = 55.6052931;
            $city->Y = 13.0001566;
            $city->radius = 13/110;
            $city->save();

            $city = new Cityzone();
            $city->city = "Göteborg";
            $city->X = 57.7072326;
            $city->Y = 11.9670171;
            $city->radius = 11/110;
            $city->save();
        }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cityzones');
    }
}
