<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  // database/migrations/xxxx_xx_xx_create_task_logs_table.php

public function up()
{
    Schema::create('task_logs', function (Blueprint $table) {
        $table->id();
        $table->string('status');
        $table->text('message');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('task_logs');
}

}
