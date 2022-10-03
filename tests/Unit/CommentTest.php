<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CommentTest extends TestCase
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
    public function testCreateCommentWrongId () 
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->postJson('/api/v1/comments', [
            'user_id'          => 99,
            'content'          => 'Thanks',
            'commentable_id'   => 1,
            'commentable_type' => 'App\\Models\\Booking',
        ]);

        $response->assertStatus(403)
            ->assertJson([
                'message' => 'Action not permitted'
            ]);
    }


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreateCommentSuccessfull () 
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->postJson('/api/v1/comments', [
            'user_id'          => 1,
            'content'          => 'Thanks',
            'commentable_id'   => 1,
            'commentable_type' => 'App\\Models\\Booking',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'user_id' => 1,
                'content' => 'Thanks'
            ]);
    }
}
