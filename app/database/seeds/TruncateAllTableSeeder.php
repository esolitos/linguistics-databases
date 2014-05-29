<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class TruncateAllTableSeeder extends Seeder {

	public function run()
	{
		
		DB::table("occurrence_object_property")->truncate();
		DB::table("occurrence")->truncate();
		DB::table("occurrence_category")->truncate();
		DB::table("object_property")->truncate();
		DB::table("category_objects")->truncate();
	}

}