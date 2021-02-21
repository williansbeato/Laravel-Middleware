<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Professor extends Migration{
   
    public function up(){
        Schema::create('professors', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    
    public function down(){
        Schema::dropIfExists('professors');
    }
}
