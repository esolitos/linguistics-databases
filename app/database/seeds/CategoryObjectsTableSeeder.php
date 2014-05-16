<?php

class CategoryObjectsTableSeeder extends Seeder {

	public function run()
	{
		$category_objs = [
			[
				'id' => '1', 
				'type' => 'IND',
				'form' => 'NP', 
				'declination' => 'ACC', 
				'has_preposition' => '1', 
			],
			[
				'id' => '2',
				'type' => 'DIR',
				'form' => 'NP', 
				'declination' => 'GEN', 
				'has_preposition' => '0', 
			],
			[
				'id' => '3',
				'type' => 'IND',
				'form' => 'PR', 
				'declination' => 'GEN', 
				'has_preposition' => '0', 
			],
			[
				'id' => '4',
				'type' => 'IND',
				'form' => 'NP', 
				'declination' => 'DAT', 
				'has_preposition' => '1', 
			],
			[
				'id' => '5',
				'type' => 'DIR',
				'form' => 'PR', 
				'declination' => 'INS', 
				'has_preposition' => '1', 
			],
			[
				'id' => '6',
				'type' => 'DIR',
				'form' => 'NP', 
				'declination' => 'INS', 
				'has_preposition' => '0', 
			],
			[
				'id' => '7',
				'type' => 'DIR',
				'form' => 'CL', 
				'declination' => 'DAT', 
				'has_preposition' => '0', 
			],
			[
				'id' => '8',
				'type' => 'IND',
				'form' => 'PR', 
				'declination' => 'ACC', 
				'has_preposition' => '0', 
			],
			[
				'id' => '9',
				'type' => 'DIR',
				'form' => 'PR', 
				'declination' => 'GEN', 
				'has_preposition' => '0', 
			],
			[
				'id' => '10',
				'type' => 'DIR',
				'form' => 'NP', 
				'declination' => 'DAT', 
				'has_preposition' => '1', 
			],
		];
		
		DB::table("category_objects")->insert($category_objs);
	}

}