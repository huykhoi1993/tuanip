<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Faker\Factory as Faker;
use Carbon\Carbon;

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

        foreach (range(1,300) as $index) {
            $is_debit = rand(0,1);
            $p = $is_debit == 1 ? -1 : 1; 

            DB::table('debits')->insert([
                'member_id'     => rand(1,100),
                'total_amount'  => $faker->numberBetween(5, 1000) * 10000 * $p,
                'is_debit'      => $is_debit,
                'pay_done'      => rand(0,1),
                'debit_note'    => $faker->text(150),
                'created_at'    => Carbon::now()->addDays(($index % 60) - 5),
                'updated_at'    => Carbon::now()->addDays(($index % 60) - 5)
            ]);
        }

    }
}
