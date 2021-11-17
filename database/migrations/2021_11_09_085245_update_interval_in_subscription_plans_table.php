<?php

use Illuminate\Database\Migrations\Migration;

class UpdateIntervalInSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE `subscription_plans` CHANGE `interval` `interval` ENUM('day', 'week', 'month', 'year', 'endless');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("ALTER TABLE `subscription_plans` CHANGE `interval` `interval` ENUM('day', 'week', 'month', 'year');");
    }
}
