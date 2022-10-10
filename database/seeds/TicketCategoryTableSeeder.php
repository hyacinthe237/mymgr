<?php

use Illuminate\Database\Seeder;

class TicketCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\TicketCategory::class, 10)->create();
    }
}
