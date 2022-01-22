<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Movie;
use App\Models\Rating;
use Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker\Factory::create();

        DB::table('users')->truncate();
        DB::table('movies')->truncate();
        DB::table('ratings')->truncate();

        $users = collect();

        $users_count = $faker->numberBetween(5, 10);

        for ($i = 1; $i <= $users_count; $i++) {
            $users->add(
                User::factory()->create([
                    'email' => 'user'.$i.'@szerveroldali.hu',
                ])
            );
        }
        User::factory()->create([
            'email' => 'admin@szerveroldali.hu',
            'is_admin' => true
        ]);

        $movies = Movie::factory(15)->create();
        Rating::factory(200)->make()->each(function ($rating) use (&$users, &$movies) {
            if($users->isNotEmpty()) {
                $rating->rated_by()->associate($users->random());
                if($movies->isNotEmpty()) {
                    $rating->rated_on()->associate($movies->random());
                }
                $rating->save();
            }
        });


    }
}
