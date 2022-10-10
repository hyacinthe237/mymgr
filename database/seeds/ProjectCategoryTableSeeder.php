<?php

use Illuminate\Database\Seeder;

class ProjectCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\ProjectCategory::class, 10)->create();
    }
}
