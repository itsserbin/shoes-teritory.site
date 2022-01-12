<?php

use App\Models\Options;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('options', function (Blueprint $table) {
            $table->string('name');
            $table->text('value')->nullable();
        });

        $result = Options::where('id', 1)
            ->select(
                'schedule',
                'phone',
                'email',
                'facebook',
                'instagram',
                'telegram',
                'viber',
                'whatsapp',
                'fb_messenger',
                'head_scripts',
                'after_body_scripts',
                'footer_scripts'
            )->first();

        DB::table('options')->insert(['name' => 'schedule', 'value' => $result['schedule']]);
        DB::table('options')->insert(['name' => 'phone', 'value' => $result['phone']]);
        DB::table('options')->insert(['name' => 'email', 'value' => $result['email']]);
        DB::table('options')->insert(['name' => 'facebook', 'value' => $result['facebook']]);
        DB::table('options')->insert(['name' => 'instagram', 'value' => $result['instagram']]);
        DB::table('options')->insert(['name' => 'viber', 'value' => $result['viber']]);
        DB::table('options')->insert(['name' => 'whatsapp', 'value' => $result['whatsapp']]);
        DB::table('options')->insert(['name' => 'telegram', 'value' => $result['telegram']]);
        DB::table('options')->insert(['name' => 'fb_messenger', 'value' => $result['fb_messenger']]);
        DB::table('options')->insert(['name' => 'head_scripts', 'value' => $result['head_scripts']]);
        DB::table('options')->insert(['name' => 'after_body_scripts', 'value' => $result['after_body_scripts']]);
        DB::table('options')->insert(['name' => 'footer_scripts', 'value' => $result['footer_scripts']]);

        Schema::table('options', function (Blueprint $table) {
            $table->dropColumn('schedule');
            $table->dropColumn('phone');
            $table->dropColumn('email');
            $table->dropColumn('facebook');
            $table->dropColumn('instagram');
            $table->dropColumn('viber');
            $table->dropColumn('whatsapp');
            $table->dropColumn('fb_messenger');
            $table->dropColumn('head_scripts');
            $table->dropColumn('after_body_scripts');
            $table->dropColumn('footer_scripts');
            $table->dropColumn('telegram');
        });

        Options::destroy(1);
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
