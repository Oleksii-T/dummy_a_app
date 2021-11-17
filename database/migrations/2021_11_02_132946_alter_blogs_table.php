<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['img', 'url']);
            $table->string('slug')->after('title')->unique();
            $table->text('content')->after('slug');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('img')->after('title')->nullable();
            $table->string('url')->after('title')->nullable();
            $table->dropColumn(['slug', 'content']);
        });
    }
}
