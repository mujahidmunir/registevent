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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('domain_name')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('office_id');
            $table->string('phone');
            $table->string('password');
            $table->tinyInteger('active')->default(0);
            $table->string('is_admin')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        \App\Models\User::create([
            'nip' => '123123',
            'domain_name' => '11.22.3333',
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'office_id' => 1,
            'phone' => '08122882296',
            'password' => \Illuminate\Support\Facades\Hash::make('123123'),
            'active' => 1,
            'is_admin' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
