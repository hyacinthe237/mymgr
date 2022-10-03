<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use DatabaseMigrations;
    const TOKEN  = 'Jy8E8Sw8bhSUa2qaWwfckVxQxouDnVuSmLhpiRcbVW3XOAnab7tTBnNmLqnH5CjPwrnzpPJ9qZFTZo83WmcU1a4AdtyX0u5eTbzjcEsKWpJxC7uwxUkbTvwoC65CcS53';

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('UsersTableSeeder');
        $this->seed('CuisineTableSeeder');
    }

    public function testCreateBookingMissingAuth () 
    {
        $response = $this->postJson('/api/v1/bookings', [
            'datetime'  => '2021-11-30 17:00',
            'duration'  => 50,
            'chef_id'   => 2,
            'dish_id'   => 1,
        ]);

        $response->assertStatus(401);
    }

    public function testCreateBookingSuccessfull () 
    {

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->postJson('/api/v1/bookings', [
            'datetime'  => '2021-11-30 17:00',
            'duration'  => 60,
            'chef_id'   => 2,
            'dish_id'   => 1,
        ]);


        $response->assertStatus(200)
            ->assertJson([
                'end_time'  => '2021-11-30 18:00',
                'status'    => 'pending',
                'amount'    => '150.0',
                'number'    => 1000101,
                'client_id' => 1,
            ]);
    }


    public function testGetClientBookingsSuccessfull () 
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->get('/api/v1/bookings?usertype=client');

        $response->assertStatus(200);
    }



    public function testGetSingleBookingSuccessfully () 
    {
        $testResult1 = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->postJson('/api/v1/bookings', [
            'datetime'  => '2023-11-30 19:00',
            'duration'  => 60,
            'chef_id'   => 2,
            'dish_id'   => 1,
        ]);

        $booking = $testResult1->decodeResponseJson();

        $testResult2 = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->get('/api/v1/bookings/' . $booking['code']);

        $testResult2->assertStatus(200)
            ->assertJson([
                'end_time'  => '2023-11-30 20:00',
                'code'      => $booking['code'],
            ])
            ->assertJsonStructure([
                'dish' => [],
                'chef' => [],
                'client' => [],
                'comments' => [],
            ]);

        $testResult3 = $this->withHeaders([
                'Authorization' => 'Bearer ' . self::TOKEN,
            ])->patchJson('/api/v1/bookings/' . $booking['code'], [
                'status'  => 'approved',
            ]);

        $testResult3->assertStatus(200)
            ->assertJson([
                'status'  => 'approved',
                'code'    => $booking['code'],
            ]);
    }
}
