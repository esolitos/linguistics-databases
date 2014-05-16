<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class OccurrenceTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 30) as $index)
		{
			DB::table("occurrence")->insert([
				'id' => $index,
				'category' => $faker->randomNumber(1, 5),
				'text' => $faker->sentence(),
				'corpus_file' => $faker->word(),
				'corpus_row' => $faker->randomNumber(1,2000),
				'keyword' => $faker->word(),
				'verb' => $faker->word(),
				'speaker' => $faker->randomElement( ['A', 'C'] )
			]);
		}
	}

}