<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('auto_generate_email')->nullable();

            $table->string('password');
            $table->string('phone');
            $table->string('bep_wallet_address');
            $table->text('admin_wallet_address');

            $table->string('deposite_slip');
            $table->string('membership_deposite');

            $table->string('joining_bonus');
            // $table->string('referal_earning');


            $table->string('writer_referal_code')->nullable();
            $table->string('referral_earning')->nullable();

            $table->enum('status', ['pending', 'approved']);
            $table->string('token')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
