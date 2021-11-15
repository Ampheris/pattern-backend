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
        $station = new Parkingspace();
        $station->X = -0.025;
        $station->Y = -0.025;
        $station->radius = 0.005;
        $station->name = 'centralen';
        $station->save();
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
