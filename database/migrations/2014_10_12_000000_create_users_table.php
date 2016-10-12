<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('active')->default(false);
            $table->string('for_activation');
            $table->timestamps();
        });

        DB::table('users')->insert([
            'name' => 'Damir Luketić',
            'email' => 'luketic.damir@gmail.com',
            // pass11 with bycript
            'password' => '$2y$10$rXYVwgvg1veWvmjxDSEo4eWIDjHVRLEuk6zVI/SbwJvqjy.zzbE6G',
            'active' => true,
            'for_activation' => '0',
            'created_at' => '2016-10-01',
            'updated_at' => '2016-10-02'
        ]);

        DB::table('users')->insert([
            'name' => 'Person 02',
            'email' => 'person02@gmail.com',
            // pass22 with bycript
            'password' => '$2y$10$L34XD391OwTWAiImztQCwe8sIGLE03KuUbdIhTVTu61UfPz8wIxWm',
            'active' => true,
            'for_activation' => '0',
            'created_at' => '2016-10-01',
            'updated_at' => '2016-10-02'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
