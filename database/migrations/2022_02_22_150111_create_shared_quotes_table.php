<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shared_quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->nullable(false)->constrained()->cascadeOnDelete();
            $table->string('destination')->nullable(false);
            $table->string('type')->unique()->nullable(false)->comment('Каким способом поделились');
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
        Schema::dropIfExists('shared_quotes');
    }
}
