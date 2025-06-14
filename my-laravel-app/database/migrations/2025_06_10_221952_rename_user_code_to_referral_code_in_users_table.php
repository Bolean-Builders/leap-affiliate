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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};







// <?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**J
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::create('users', function (Blueprint $table) {
//             $table->id();
//             $table->string('name');
//             $table->string('username')->unique();
//             $table->string('email')->unique();
//             $table->timestamp('email_verified_at')->nullable();
//             $table->string('password');
//             $table->string('role');
//             $table->string('user_type');
//             $table->string('referral_code')->unique();
//             $table->timestamp('last_login_at')->nullable();
//             $table->ipAddress('last_login_ip')->nullable();
//             $table->rememberToken();
//             $table->timestamps();
            
//             // Indexes
//             $table->index('role');
//             $table->index('user_type');
//             $table->index('referral_code');
//             $table->index('last_login_at');
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('users');
//     }
// };