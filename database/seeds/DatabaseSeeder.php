<?php

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
        $this->call([
            UserTableSeeder::class,
            OrganizationTableSeeder::class,
            ProjectCategoryTableSeeder::class,
            TicketCategoryTableSeeder::class,
            ProjectTableSeeder::class,
            TicketTableSeeder::class,
            TicketTableSeeder::class,
            InvitationTableSeeder::class,
        ]);
    }
}
