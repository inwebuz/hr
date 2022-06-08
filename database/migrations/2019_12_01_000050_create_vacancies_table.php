<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Vacancy;

class CreateVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->nullable();
            $table->string('brand')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('background')->nullable();
            $table->text('images')->nullable();
            $table->text('description')->nullable();
            $table->text('body')->nullable();
            $table->decimal('salary', 15, 2)->default(0);
            $table->tinyInteger('status')->default(Vacancy::STATUS_INACTIVE);
            $table->string('seo_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
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
        Schema::dropIfExists('vacancies');
    }
}
