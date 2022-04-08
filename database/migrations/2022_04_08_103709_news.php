<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->integer('id', true)->unsigned();
            $table->integer('source_id')->unsigned();
            $table->string('source_name');                 
            $table->string('title');                        
            $table->string('link');
            $table->string('img_url');
            $table->integer('times_read')->default(0)->unsigned();
            $table->dateTime('external_created_at');            
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
        //
    }
};
