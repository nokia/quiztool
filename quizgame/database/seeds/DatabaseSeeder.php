<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        $this->call(QuestionGroupsTableSeeder::class);
        $this->call(QuestionTableSeeder::class);
        $this->call(AnswerTableSeeder::class);

        /*Eloquent::unguard();

        $this->call('UserTableSeeder');
        $this->command->info('User table seeded!');

        $path = 'app/developer_docs/countries.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Country table seeded!')*/
    }
}
