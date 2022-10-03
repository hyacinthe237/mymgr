<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CuisineTest extends TestCase
{
    use DatabaseMigrations;

    const CODE = 'e74e6b8b-7bb7-4ed8-9834-e7c92a57e3b8';
    const TOKEN  = 'Jy8E8Sw8bhSUa2qaWwfckVxQxouDnVuSmLhpiRcbVW3XOAnab7tTBnNmLqnH5CjPwrnzpPJ9qZFTZo83WmcU1a4AdtyX0u5eTbzjcEsKWpJxC7uwxUkbTvwoC65CcS53';

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('UsersTableSeeder');
        $this->seed('CuisineTableSeeder');
    }


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGetCuisine ()
    {   
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->json('GET', '/api/v1/cuisines/' . self::CODE);

        $response->assertStatus(200);
    }


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGetCuisineChefs ()
    {   
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->json('GET', '/api/v1/cuisines/' . self::CODE . '/chefs');

        $response->assertStatus(200);
    }

}
