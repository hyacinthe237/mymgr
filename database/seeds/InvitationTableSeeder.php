<?php

use Illuminate\Database\Seeder;

class InvitationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       factory(App\Models\Invitation::class, 10)->create();
    }
}
