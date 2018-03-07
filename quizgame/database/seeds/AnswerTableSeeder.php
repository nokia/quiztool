<?php

use Illuminate\Database\Seeder;

class AnswerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('answers')->insert(array(
        	array(	'id' => '66', 'question_id'	=> '17', 'text' => 'IC1 / OC1', 'is_right' => '0'),
        	array(	'id' => '67', 'question_id'	=> '17', 'text' => 'IC2 / OC2', 'is_right' => '0'),
        	array(	'id' => '68', 'question_id'	=> '17', 'text' => 'IC3 / OC3', 'is_right' => '1'),
        	array(	'id' => '69', 'question_id'	=> '17', 'text' => 'IC4 / OC4', 'is_right' => '0'),
        	array(	'id' => '70', 'question_id'	=> '17', 'text' => 'IC9', 'is_right' => '0'),
        	array(	'id' => '89', 'question_id'	=> '22', 'text' => 'Handles the calls coming from the incoming signalling.', 'is_right' => '0'),
        	array(	'id' => '90', 'question_id'	=> '22', 'text' => 'Handles the calls going to the outgong signalling.', 'is_right' => '0'),
        	array(	'id' => '91', 'question_id'	=> '22', 'text' => 'Handles the creation of new legs.', 'is_right' => '1'),
        	array(	'id' => '92', 'question_id'	=> '22', 'text' => 'Handles the calls going to Mobiles.', 'is_right' => '0'),
        	array(	'id' => '5624', 'question_id'	=> '35', 'text' => 'Early', 'is_right' => '1'),
        	array(	'id' => '5625', 'question_id'	=> '35', 'text' => 'Late', 'is_right' => '0'),
        	array(	'id' => '289', 'question_id'	=> '70', 'text' => 'SRBT', 'is_right' => '0'),
            array(  'id' => '290', 'question_id'   => '70', 'text' => 'MultiCall', 'is_right' => '1'),
            array(  'id' => '291', 'question_id'   => '70', 'text' => 'CollectCall', 'is_right' => '0'),
    	));
    }
}
