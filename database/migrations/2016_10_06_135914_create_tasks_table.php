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

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        DB::table('tasks')->insert([
            'user_id'        => 1,
            'name'           => 'Task 01',
            'start_date'     => '2016-09-25',
            'end_date'       => '2016-10-11',
            'description'    =>'Description of task 01',
            'status'         => false,
            'created_at' => '2016-10-01',
            'updated_at' => '2016-10-10'
        ]);

        DB::table('tasks')->insert([
            'user_id'        => 1,
            'name'           => 'Task 02',
            'start_date'     => '2016-10-07',
            'end_date'       => '2016-11-12',
            'description'    =>'Description of task 02',
            'status'         => true,
            'created_at' => '2016-10-01',
            'updated_at' => '2016-10-15'
        ]);

        DB::table('tasks')->insert([
            'user_id'        => 1,
            'name'           => 'Task 03',
            'start_date'     => '2016-10-10',
            'end_date'       => '2016-10-25',
            'description'    =>'Description of task 03',
            'status'         => false,
            'created_at' => '2016-10-01',
            'updated_at' => '2016-10-20'
        ]);

        DB::table('tasks')->insert([
            'user_id'        => 1,
            'name'           => 'Task 04',
            'start_date'     => '2016-10-25',
            'end_date'       => '2016-12-25',
            'description'    =>'Description of task 04',
            'status'         => true,
            'created_at' => '2016-10-01',
            'updated_at' => '2016-10-25'
        ]);

        DB::table('tasks')->insert([
            'user_id'        => 2,
            'name'           => 'Task 05',
            'start_date'     => '2016-10-15',
            'end_date'       => '2016-10-25',
            'description'    =>'Description of task 05',
            'status'         => false,
            'created_at' => '2016-10-01',
            'updated_at' => '2016-10-02'
        ]);

        DB::table('tasks')->insert([
            'user_id'        => 2,
            'name'           => 'Task 06',
            'start_date'     => '2016-10-23',
            'end_date'       => '2016-10-25',
            'description'    =>'Description of task 06',
            'status'         => false,
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
        Schema::dropIfExists('tasks');
    }
}
