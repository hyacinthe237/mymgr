<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AppTest extends TestCase
{
    use DatabaseMigrations;

    const TOKEN = 'Jy8E8Sw8bhSUa2qaWwfckVxQxouDnVuSmLhpiRcbVW3XOAnab7tTBnNmLqnH5CjPwrnzpPJ9qZFTZo83WmcU1a4AdtyX0u5eTbzjcEsKWpJxC7uwxUkbTvwoC65CcS53';


    public function setUp(): void
    {
        parent::setUp();
        $this->seed('UsersTableSeeder');
    }


    /**
     * Get default lists 
     */
    public function testGetLists () 
    {
        $response = $this->json('GET', '/api/v1/lists');

        $response->assertStatus(200)
            ->assertJson([
                'states' => [],
                'cuisines' => [],
            ]);
    }
}
