<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BlogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
		$date = new DateTime();
		$dateTime = $date->format('Y-m-d H:i:s');

    	foreach (range(1,1) as $index) {
	        DB::table('users')->insert([
	            'name' => 'admin',
	            'email' => 'admin@admin.com',
	            'password' => bcrypt('admin'),
	            'user_type' => 'admin',
	            'created_at' => $dateTime,
	            'updated_at' => $dateTime,
	        ]);
		}
    	foreach (range(1,100) as $index) {
	        DB::table('blogs')->insert([
	            'blogs_title' => $faker->text(50),
	            'blogs_body' => $faker->realText,
	            'user_id' => '1',
	            'category_id' => '1',
	            'created_at' => $dateTime,
	            'updated_at' => $dateTime,
	        ]);
		}
    	foreach (range(1,10) as $index) {
	        DB::table('users')->insert([
	            'name' => $faker->name,
	            'email' => $faker->email,
	            'password' => bcrypt('secret'),
	            'created_at' => $dateTime,
	            'updated_at' => $dateTime,
	        ]);
		}
    	foreach (range(1,10) as $index) {
	        DB::table('categories')->insert([
	            'categories_name' => "categorie-".$index,
	            'created_at' => $dateTime,
	            'updated_at' => $dateTime,
	        ]);
		}
    }
}
