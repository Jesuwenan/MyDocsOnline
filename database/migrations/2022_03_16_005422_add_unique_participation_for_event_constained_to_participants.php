<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueParticipationForEventConstainedToParticipants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->unique(['event_id', 'person_id','company_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participants', function (Blueprint $table) {

            $table->dropUnique(['event_id', 'person_id','company_id']);
            //$table->dropIndex('participants_event_id_person_id_company_id_unique');
            //$table->dropUnique('participants_event_id_person_id_company_id_unique');
        });
    }
}
