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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role')->nullable();
            $table->string('picture')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_premium')->nullable();
            $table->dateTime('premium_period')->nullable();
            $table->integer('otp')->nullable();
            $table->string('fcm')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('phone');
            $table->dropColumn('is_premium');
            $table->dropColumn('premium_period');
            $table->dropColumn('otp');
            $table->dropColumn('fcm');
        });
    }
};
