<?php

use Illuminate\Database\Seeder;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert(array(
        	array(	'id' => '17', 'text'	=> 'What are the incoming / outgoing Call Control program blocks for Trunk calls?
', 'group_id' => '76'),
        	array(	'id' => '22', 'text'	=> 'What is the CFO program block good for?', 'group_id' => '76'),
            array(  'id' => '35', 'text'    => 'In the first HLR enquiry the C-number got, then the routing is continued based on this number. Which Call Forwarding is it?
', 'group_id' => '76'),
        	array(	'id' => '70', 'text'	=> 'Which is not IN service?', 'group_id' => '79')
    	));
    }
}
