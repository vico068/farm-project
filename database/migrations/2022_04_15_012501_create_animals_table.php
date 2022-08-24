<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('farm_id');
            $table->unsignedBigInteger('iron_id')->nullable();
            $table->unsignedBigInteger('breed_id')->nullable();
            $table->string('earring')->nullable();
            $table->unique(['tenant_id', 'earring']);
            $table->string('nickname')->nullable();
            $table->string('obs')->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->boolean('active')->default(true);
            $table->foreign('farm_id')->references('id')->on('farms');
            $table->foreign('iron_id')->references('id')->on('irons');
            $table->foreign('breed_id')->references('id')->on('breeds');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('tenant_id')
            ->references('id')
            ->on('tenants')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animals');
    }
}
