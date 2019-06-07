<?php

use Illuminate\Database\Seeder;
// use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

      $faker = Faker\Factory::create();

      $forms = [
        'e_o_insurance' => [
          'label' => 'E&O Insurance',
          'description' => 'If Professional Liability, need all schedules showing covered for E&O within the policy acting as title agent or while conducting title related services',
        ],
        'cpl' => [
          'label' => 'CPL',
          'description' => 'NY Equivalent = Proof of Fidelity coverage (bond) in the amount of which is the greater of $1,000,000.00',
        ],
        'wire_instructions' => [
          'label' => 'Wire Instructions',
          'description' => 'Must be on company letterhead and have contact information',
        ],
        'mbfg_instructions' => [
          'label' => 'MBFG Instructions',
          'description' => 'This is the document you downloaded to the left, complete & upload as well',
        ],
        'sample_cd' => [
          'label' => 'Sample CD',
          'description' => 'Sample CD must show fees accurately',
        ],
        'business_license' => [
          'label' => 'Copy of Business License',
          'description' => 'Please include a copy of a valid business license',
        ],
      ];

      foreach ($forms as $key => $value) {
        DB::table('forms')->insert([
            'file_name' => $value['label'],
            'file_slug' => $key,
            'description' => $value['description'],
        ]);
      }

      $statuses = [
        'denied' => [],
        'approved' => [],
        'pending' => [],
        'banned' => [],
      ];

      foreach ($statuses as $key => $value) {
        DB::table('statuses')->insert([
            'name' => $key,
        ]);
      }

      DB::table('users')->insert([
          'name' => env('SEEDER_USER_NAME', 'John Doe'),
          'email' => env('SEEDER_USER_EMAIL', 'test@test.com'),
          'password' => Hash::make(env('SEEDER_USER_PASSWORD', 'password')),
          'created_at' => new DateTime,
          'updated_at' => new DateTime,
      ]);

      DB::table('users')->insert([
          'name' => env('SEEDER_USER_NAME_2', 'John Doe'),
          'email' => env('SEEDER_USER_EMAIL_2', 'test@test.com'),
          'password' => Hash::make(env('SEEDER_USER_PASSWORD_2', 'password')),
          'created_at' => new DateTime,
          'updated_at' => new DateTime,
      ]);

    }
}
