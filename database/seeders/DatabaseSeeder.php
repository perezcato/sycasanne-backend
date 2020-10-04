<?php

namespace Database\Seeders;

use App\Models\Configuration\ESchoolResource;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        ESchoolResource::factory(2)->create();
    }
}
