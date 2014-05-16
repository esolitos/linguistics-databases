<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		// $this->call('UserTableSeeder');
		$this->call('TruncateAllTableSeeder');
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		
		$this->call("UserSeeder");
		
		$this->call('CategoryObjectsTableSeeder');
		$this->call('ObjectPropertyTableSeeder');
		$this->call('OccurrenceCategoryTableSeeder');
		$this->call('OccurrenceTableSeeder');
		$this->call('OccurrenceObjectPropertyTableSeeder');
		
	}

}
