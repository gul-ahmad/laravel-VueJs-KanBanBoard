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
        Schema::create('columns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        //we are creating few columns when ever migrations run

        \App\Models\Column::create(['title' => 'Pending Tasks']);
        \App\Models\Column::create(['title' => 'Todo Tasks']);
        \App\Models\Column::create(['title' => 'Tasks UnderReview']);
        \App\Models\Column::create(['title' => 'Tasks Approved']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('columns');
    }
};
