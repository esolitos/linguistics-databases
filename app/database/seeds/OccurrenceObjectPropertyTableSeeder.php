<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class OccurrenceObjectPropertyTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 36) as $index)
		{
			DB::table("occurrence_object_property")->insert([
				'occurrence_id' => (int) $index/2,
				'type' => ($index %2) ? 'IND' : 'DIR',
				'property_id' => $faker->randomNumber(1,20)
			]);
		}
	}

}