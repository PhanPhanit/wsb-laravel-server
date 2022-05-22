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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->string('author');
            $table->string('publisher');
            $table->string('genre');
            $table->string('language');
            $table->string('country');
            $table->string('published');
            $table->text('description');
            $table->json('image');
            $table->decimal('averageRating', 2, 1)->default(0);
            $table->bigInteger('numOfReviews')->default(0);
            $table->unsignedBigInteger('user');
            $table->unsignedBigInteger('category');
            $table->bigInteger('sold')->default(0);
            $table->bigInteger('views')->default(0);
            $table->boolean('isShow')->default(true);
            $table->foreign('user')
                ->references('id')
                ->on('users');
            $table->foreign('category')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
};
