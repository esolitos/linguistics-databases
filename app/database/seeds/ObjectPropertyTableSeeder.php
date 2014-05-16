<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ObjectPropertyTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 20) as $index)
		{
			DB::table("object_property")->insert([
				'id' => $index,
				'name' => $faker->firstName()
			]);
		}
	}

}