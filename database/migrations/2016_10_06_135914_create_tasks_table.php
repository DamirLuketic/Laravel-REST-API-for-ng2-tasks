<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('description');
            $table->boolean('status')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        DB::table('tasks')->insert([
            'user_id'        => 1,
            'name'           => 'Task 01',
            'start_date'     => '2016-10-15',
            'end_date'       => '2016-10-25',
            'description'    =>'Description of task 01',
            'status'         => false
        ]);

        DB::table('tasks')->insert([
            'user_id'        => 1,
            'name'           => 'Task 02',
            'start_date'     => '2016-10-23',
            'end_date'       => '2016-10-25',
            'description'    =>'Description of task 02',
            'status'         => true
        ]);

        DB::table('tasks')->insert([
            'user_id'        => 1,
            'name'           => 'Task 03',
            'start_date'     => '2016-11-15',
            'end_date'       => '2016-11-25',
            'description'    =>'Description of task 03',
            'status'         => false
        ]);

        DB::table('tasks')->insert([
            'user_id'        => 1,
            'name'           => 'Task 04',
            'start_date'     => '2016-12-15',
            'end_date'       => '2016-12-25',
            'description'    =>'Description of task 04',
            'status'         => true
        ]);

        DB::table('tasks')->insert([
            'user_id'        => 2,
            'name'           => 'Task 05',
            'start_date'     => '2016-10-15',
            'end_date'       => '2016-10-25',
            'description'    =>'Description of task 05',
            'status'         => false
        ]);

        DB::table('tasks')->insert([
            'user_id'        => 2,
            'name'           => 'Task 06',
            'start_date'     => '2016-10-23',
            'end_date'       => '2016-10-25',
            'description'    =>'Description of task 06',
            'status'         => false
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}