<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('pickupLocation')->nullable();
          $table->datetime('pickupDate')->nullable();
          $table->text('instruction')->nullable();
          $table->integer('listing_id')->nullable();
          $table->integer('agent_id')->nullable();
          $table->string('tenant_id')->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
