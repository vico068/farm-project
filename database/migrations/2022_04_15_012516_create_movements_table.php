<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('farm_id');
            $table->unsignedBigInteger('animal_id')->nullable();
            $table->unsignedBigInteger('collect_id')->nullable();
            $table->unsignedBigInteger('movement_type_id')->nullable();
            $table->unsignedBigInteger('origin_farm_id')->nullable();

            $table->string('movement_name')->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('note')->nullable();
            $table->boolean('is_animal')->default(true);
            $table->enum('operation', ['E', 'S', 'TE', 'TS', 'AV']);
            $table->date('movement_date');
            $table->boolean('moves_animals')->default(true);
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('movements');
    }
}
