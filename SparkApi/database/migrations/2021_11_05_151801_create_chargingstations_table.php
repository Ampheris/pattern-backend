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
            $table->integer('available')->nullable();
            $table->string('name');
            $table->timestamps();
        });
        $this->migrationCreate();
    }
    
    public function migrationCreate() {
            $position = 0.025;

            $station = new Chargingstation();
            $station->X = 59.3251172;
            $station->Y = 18.0710935 - $position;
            $station->radius = 1/110;
            $station->name = 'Stureplan';
            $station->save();

            $station = new Chargingstation();
            $station->X = 55.6052931;
            $station->Y = 13.0001566 - $position;
            $station->radius = 1/110;
            $station->name = 'Vattnet';
            $station->save();

            $station = new Chargingstation();
            $station->X = 57.7072326;
            $station->Y = 11.9670171 - $position;
            $station->radius = 1/110;
            $station->name = 'Göran';
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
