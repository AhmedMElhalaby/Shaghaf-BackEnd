<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraCulomnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('provider_type')->nullable();
            $table->string('company_name')->nullable();
            $table->string('maroof_cert')->nullable();
            $table->string('commercial_cert')->nullable();
            $table->boolean('profile_completed')->default(false);
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
            $table->dropColumn('provider_type');
            $table->dropColumn('company_name');
            $table->dropColumn('maroof_cert');
            $table->dropColumn('commercial_cert');
            $table->dropColumn('profile_completed');
        });
    }
}
