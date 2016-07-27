<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = \App\User::lists('id')->all();

        foreach(range(1,5) as $index){
            $jobs = \App\Job::create([
                'user_id' => $faker->randomElement($users),
                'title' => str_random(10),
                'description' => str_random(10),
                'status' => str_random(10),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
