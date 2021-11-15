<?php

use App\Models\Chargingstation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargingstationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chargingstations', function (Blueprint $table) {
            $table->id();
            $table->float('X');
            $table->float('Y');
            $table->float('radius');
            $table->integer('available');
            $table->string('name');
            $table->timestamps();
        });
        $this->migrationCreate();
    }
    public function migrationCreate() {
        $station = new Chargingstation();
        $station->X = 0.025;
        $station->Y = 0.025;
        $station->radius = 0.005;
        $station->name = 'hamnen';
        $station->save();
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chargingstations');
    }
}
