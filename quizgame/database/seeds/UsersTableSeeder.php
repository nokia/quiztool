<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array(
        	array(	'id' => '1', 'username'	=> 'Root', 'email' => 'nothin',
        		'password' => Hash::make('1234'), 'is_admin' => '1', 'active_game' => null),
        	array(	'id' => '2', 'username'	=> 'user1', 'email' => 'nothin1',
        		'password' => Hash::make('1234'), 'is_admin' => '0', 'active_game' => null),
        	array(	'id' => '3', 'username'	=> 'user2', 'email' => 'nothin2',
        		'password' => Hash::make('1234'), 'is_admin' => '0', 'active_game' => null),
            array(  'id' => '4', 'username' => 'user3', 'email' => 'nothin21',
                'password' => Hash::make('1234'), 'is_admin' => '0', 'active_game' => null),
            array(  'id' => '5', 'username' => 'user4', 'email' => 'nothin22',
                'password' => Hash::make('1234'), 'is_admin' => '0', 'active_game' => null),
            array(  'id' => '6', 'username' => 'user5', 'email' => 'nothin23',
                'password' => Hash::make('1234'), 'is_admin' => '0', 'active_game' => null),
            array(  'id' => '7', 'username' => 'user6', 'email' => 'nothin24',
                'password' => Hash::make('1234'), 'is_admin' => '0', 'active_game' => null),
            array(  'id' => '8', 'username' => 'user7', 'email' => 'nothin25',
                'password' => Hash::make('1234'), 'is_admin' => '0', 'active_game' => null),
            array(  'id' => '9', 'username' => 'user8', 'email' => 'nothin26',
                'password' => Hash::make('1234'), 'is_admin' => '0', 'active_game' => null),
            array(  'id' => '10', 'username' => 'user9', 'email' => 'nothin27',
                'password' => Hash::make('1234'), 'is_admin' => '0', 'active_game' => null),
    	));
    }
}
