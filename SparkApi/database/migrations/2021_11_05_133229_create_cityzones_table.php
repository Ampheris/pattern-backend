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
    public function migrationCreate() {
        $city = new Cityzone();
        $city->city = "Karlskrona";
        $city->X = 0;
        $city->Y = 0;
        $city->radius = 0.25;
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
