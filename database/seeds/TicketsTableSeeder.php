<?php

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ticket::create([
            'number' => 1101,
            'user_id' => 2,
            'status' => 'pending', 
            'title' => 'My chef did not come to booking', 
            'description' => 'I waited for hours and the chef did not come. I tried texting, no reply'
        ]);

        Ticket::create([
            'number' => 1104,
            'user_id' => 3,
            'status' => 'pending', 
            'title' => 'Booking disappeared from my booking list', 
            'description' => 'I had a booking today that I could not attend because I did not have the address'
        ]);
    }
}
