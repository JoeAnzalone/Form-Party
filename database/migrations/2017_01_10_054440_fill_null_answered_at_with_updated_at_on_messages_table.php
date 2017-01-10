<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Message;

class FillNullAnsweredAtWithUpdatedAtOnMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('messages')->whereNull('answered_at')->where('status_id', Message::STATUS_ANSWERED_PUBLICLY)->update(['answered_at' => DB::raw('`updated_at`')]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
