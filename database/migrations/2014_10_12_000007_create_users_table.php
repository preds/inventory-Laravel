<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('localisation');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique();
            $table->string('password');
            $table->unsignedBigInteger('group_id'); // Reference to groups table
            $table->string('status')->default('Active');
            $table->boolean('password_reset_required')->default(true);
            $table->timestamp('last_login')->nullable();
            $table->string('photo')->nullable();
            $table->rememberToken();
            $table->timestamps();
            // Adding foreign key constraint
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
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
}
