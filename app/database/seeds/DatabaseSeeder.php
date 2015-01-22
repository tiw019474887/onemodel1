<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$user = new User();
        $user->email = "chaow.po@up.ac.th";
        $user->password = Hash::make("1234");
        $user->save();
	}

}
