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
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $data = ["CABANG UTAMA BANDUNG", "CABANG KARAWANG", "CABANG SUKABUMI", "CABANG SUBANG", "CABANG CIANJUR", "CABANG PURWAKARTA", "CABANG SOREANG", "CABANG CIMAHI", "CABANG SUCI", "CABANG TAMANSARI", "CABANG PELABUHAN RATU", "CABANG PADALARANG", "CABANG SUMBER SARI", "CABANG MAJALAYA", "CABANG BUAH BATU", "CABANG SUKAJADI", "CABANG JATINANGOR", "CABANG BEKASI", "CABANG BOGOR", "CABANG DEPOK", "CABANG CIKARANG", "CABANG RAWAMANGUN", "CABANG CIBINONG", "CABANG KHUSUS JAKARTA", "CABANG KEBAYORAN BARU", "CABANG GAJAH MADA", "CABANG MEDAN", "CABANG BATAM", "CABANG PEKANBARU", "CABANG HASYIM ASHARI", "CABANG PALEMBANG", "CABANG RASUNA SAID", "CABANG S PARMAN", "CABANG SAHARJO", "CABANG CIREBON", "CABANG CIAMIS", "CABANG TASIKMALAYA", "CABANG INDRAMAYU", "CABANG SUMEDANG", "CABANG KUNINGAN", "CABANG MAJALENGKA", "CABANG GARUT", "CABANG SUMBER", "CABANG BANJAR", "CABANG PATROL", "CABANG PANGANDARAN"];
        $insert = [];
        foreach ($data as $name) {
            $insert[] = ['name' => $name, 'created_at' => now(), 'updated_at' => now()];
        }
        \App\Models\Office::insert($insert);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offices');
    }
};
