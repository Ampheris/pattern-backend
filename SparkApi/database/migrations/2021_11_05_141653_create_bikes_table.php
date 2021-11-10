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

        for ($i = 0; $i < 10; $i++) {
            $bike = new Bike();
            $bike->status = "tillgänglig";
            $bike->battery = 100;
            $bike->velocity = 0;
            $bike->X = 0;
            $bike->Y = 0;
            $bike->save();
        }
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
