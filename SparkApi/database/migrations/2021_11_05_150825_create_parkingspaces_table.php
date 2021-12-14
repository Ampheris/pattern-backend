<?php

use App\Models\Parkingspace;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkingspacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parkingspaces', function (Blueprint $table) {
            $table->id();
            $table->float('X');
            $table->float('Y');
            $table->float('radius');
            $table->integer('available')->nullable();
            $table->string('name');
            $table->timestamps();
        });
        $this->migrationCreate();
    }
    
    public function migrationCreate()
    {
        $position = 0.025;

        $city = new Parkingspace();
        $city->X = 59.3251172 - $position;
        $city->Y = 18.0710935;
        $city->radius = 1/110;
        $city->name = 'T-centralen';
        $city->save();

        $city = new Parkingspace();
        $city->X = 55.6052931 - $position;
        $city->Y = 13.0001566;
        $city->radius = 1/110;
        $city->name = 'Red hawk';
        $city->save();

        $city = new Parkingspace();
        $city->X = 57.7072326 - $position;
        $city->Y = 11.9670171;
        $city->radius = 1/110;
        $city->name = 'Glenn';
        $city->save();
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parkingspaces');
    }
}
