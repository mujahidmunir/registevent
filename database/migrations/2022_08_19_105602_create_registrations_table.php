<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_id')->index();
            $table->integer('cs_id');
            $table->integer('office_id');
            $table->string('ticket_id')->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->index();
            $table->string('city');
            $table->string('address');
            $table->string('email')->index();
            $table->string('ktp')->index();
            $table->string('bank_id');
            $table->string('cif')->index();
            $table->string('rrn');
            $table->tinyInteger('digi');
            $table->tinyInteger('digicash');
            $table->tinyInteger('validation')->default(0);
            $table->index(['phone', 'cif']);
            $table->integer('quantity')->default(1);
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
        Schema::dropIfExists('registrations');
    }
};
