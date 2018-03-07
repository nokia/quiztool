<?php

use Illuminate\Database\Seeder;

class QuestionGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_groups')->insert(array(
        	array(	'id' => '76', 'name'	=> 'Group1', 'parent_id' => '0'),
        	array(	'id' => '79', 'name'	=> 'Group2', 'parent_id' => '0')
    	));    }
}
