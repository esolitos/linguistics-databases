<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class OccurrenceCategoryTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 6) as $index)
		{
			DB::table("occurrence_category")->insert([
				'id' => $index,
				'first_object' => $faker->randomNumber(1, 10),
				'second_object' => $faker->randomNumber(1, 10),
			]);
		}
	}

}