<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DishTest extends TestCase
{
    use DatabaseMigrations;

    const CODE = 'e91e6b8a-5bb2-4fd8-9834-f7c92c57e2b9';
    const TOKEN  = 'Jy8E8Sw8bhSUa2qaWwfckVxQxouDnVuSmLhpiRcbVW3XOAnab7tTBnNmLqnH5CjPwrnzpPJ9qZFTZo83WmcU1a4AdtyX0u5eTbzjcEsKWpJxC7uwxUkbTvwoC65CcS53';

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('UsersTableSeeder');
        $this->seed('CuisineTableSeeder');
    }

    public function testCreateDishMissingAuth () 
    {
        $response = $this->postJson('/api/v1/dishes', [
            'name'        => 'Ndolè',
            'price'       => 250,
            'serves'      => 8,
            'duration'    => 90,
            'cuisine_id'  => 2,
            'ingredients' => 'oil,salt,pepper,sugar,lime,lemon'
        ]);

        $response->assertStatus(401);
    }


    public function testCreateDishMissingRequiredParams () 
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->postJson('/api/v1/dishes', [
            'name'        => '',
            'price'       => 250,
            'serves'      => 8,
            'duration'    => 90,
            'cuisine_id'  => 2,
            'ingredients' => 'oil,salt,pepper,sugar,lime,lemon'
        ]);
        
        $response->assertStatus(400)
            ->assertJson([
                'name' => [
                    0 => "The name field is required."
                ],
            ]);
    }

    public function testCreateAndUpdateDishSuccessfull () 
    {
        $resp1 = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->postJson('/api/v1/dishes', [
            'name'        => 'Ndolè',
            'price'       => 250,
            'serves'      => 8,
            'duration'    => 90,
            'cuisine_id'  => 2,
            'ingredients' => 'oil,salt,pepper,sugar,lime,lemon'
        ]);

        $resp1->assertStatus(200)
            ->assertJson([
                'name'      => 'Ndolè',
                'duration'  => 90
            ]);

        $dish = $resp1->decodeResponseJson();
        
        $resp2 = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->patchJson('/api/v1/dishes/' . $dish['code'], [
            'name'  => 'Bobolo',
            'price'  => 220,
            'serves'  => 6,
            'duration'  => 60,
            'cuisine_id'  => 2,
            'ingredients'  => $dish['ingredients']
        ]);

        $resp2->assertStatus(200)
            ->assertJson([
                'name'  => 'Bobolo',
                'price' => 220,
                'serves' => 6,
                'code'  => $dish['code']
            ]);
    }
}
