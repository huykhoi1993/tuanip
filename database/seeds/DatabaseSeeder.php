<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $faker = Faker::create('vi_VN');

        foreach (range(1,100) as $index) {
            DB::table('members')->insert([
                'member_name' 		=> $faker->firstName,
				'member_phone' 		=> $faker->phoneNumber,
				'is_female' 		=> rand(0,1),
				'member_address' 	=> $faker->address,
				'member_note' 		=> $faker->text(200),
				'debt' 				=> $faker->numberBetween(5, 1000) * 10000 * rand( -1, 1)
            ]);
        }
    }
}
