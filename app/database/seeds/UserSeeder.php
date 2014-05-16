<?php

class UserSeeder extends Seeder {

	public function run()
	{
		$users = array(
			array(
				"username" => "adam",
				"password" => Hash::make("adam"),
				"email" => "esolitos@gmail.com"
			)
		);
  
		foreach ($users as $user) {
			User::create($user);
		}

	}

}