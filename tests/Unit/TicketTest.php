<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use DatabaseMigrations;

    const TOKEN  = 'Jy8E8Sw8bhSUa2qaWwfckVxQxouDnVuSmLhpiRcbVW3XOAnab7tTBnNmLqnH5CjPwrnzpPJ9qZFTZo83WmcU1a4AdtyX0u5eTbzjcEsKWpJxC7uwxUkbTvwoC65CcS53';

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('UsersTableSeeder');
    }

    public function testCreateDishMissingAuth () 
    {
        $response = $this->postJson('/api/v1/tickets', [
            'title'       => 'Ticket Unit',
            'description' => 'Unit test created this ticket'
        ]);

        $response->assertStatus(401);
    }


    public function testCreateDishMissingRequiredParams () 
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->postJson('/api/v1/dishes', [
            'title'       => 'Ticket Unit',
            'description' => 'Unit test created this ticket'
        ]);
        
        $response->assertStatus(400)
            ->assertJson([
                'title' => [
                    0 => "The title field is required."
                ],
            ]);
    }

    public function testCreateAndUpdateDishSuccessfull () 
    {
        $resp1 = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->postJson('/api/v1/dishes', [
            'title'       => 'Ticket Unit',
            'description' => 'Unit test created this ticket'
        ]);

        $resp1->assertStatus(200)
            ->assertJson([
                'title'   => 'Ticket Unit',
                'user_id' => 2
            ]);

        $dish = $resp1->decodeResponseJson();
        
        $resp2 = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->patchJson('/api/v1/dishes/' . $dish['code'], [
            'title'       => 'Ticket Units',
            'description' => 'Units test created this ticket'
        ]);

        $resp2->assertStatus(200)
            ->assertJson([
                'title'  => 'Ticket Units',
                'updated_by' => 2,
            ]);
    }
}
