<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    const PIN       = 139253;
    const PASSWORD  = 'secret';
    const USERNAME  = 'testuser';
    const CODE      = '47477760-59ba-11eb-9222-fbe4163e8823';
    const TOKEN     = 'Jy8E8Sw8bhSUa2qaWwfckVxQxouDnVuSmLhpiRcbVW3XOAnab7tTBnNmLqnH5CjPwrnzpPJ9qZFTZo83WmcU1a4AdtyX0u5eTbzjcEsKWpJxC7uwxUkbTvwoC65CcS53';

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('UsersTableSeeder');
    }


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testVerifyWrongPin ()
    {   
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->json('GET', '/api/v1/verify-pin/123456');

        $response->assertStatus(400);
    }


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testVerifyPinSuccessfull ()
    {   
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->json('GET', '/api/v1/verify-pin/' . self::PIN);

        $response->assertStatus(200);
    }


    public function testSigninWrongPassword () 
    {
        $response = $this->postJson('/api/v1/signin', [
            'username' => self::USERNAME,
            'password' => 'secrets',
        ]);

        $response->assertStatus(400);
    }


    public function testSigninWrongUsername () 
    {
        $response = $this->postJson('/api/v1/signin', [
            'username' => 'testusers',
            'password' => self::PASSWORD,
        ]);

        $response->assertStatus(400);
    }


    public function testSigninSuccessfull () 
    {
        $response = $this->postJson('/api/v1/signin', [
            'username' => self::USERNAME,
            'password' => self::PASSWORD,
        ]);

        $response->assertStatus(200);
    }


    public function testUpdateMeSuccessfull () 
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->postJson('/api/v1/me', [
            'card_last_digits'  => '9876',
            'date_of_birth'     => '2002-02-09',
            'card_expiry'       => '11/22',
            'country_id'        => 1,
            'firstname'         => 'Testo',
            'username'          => 'testuser',
            'lastname'          => 'Toste',
            'postcode'          => '2000',
            'address'           => '17 Eddy avenue',
            'role_id'           => 3,
            'suburb'            => 'Sydney',
            'status'            => 'active',
            'mobile'            => '0422942031',
            'state'             => 'nsw',
            'email'             => 'eddy.insearch@gmail.com',
            'pin'               =>  '',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'date_of_birth' => '2002-02-09',
                'mobile'        => '0422942031',
                'status'        => 'active'
            ]);
    }


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGetChefs ()
    {   
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->json('GET', '/api/v1/chefs/');


        $response->assertStatus(200);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGetMaleChefs ()
    {   
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->json('GET', '/api/v1/chefs?sex=male');


        $response->assertStatus(200);
    }


    public function testGetChefDishes () 
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TOKEN,
        ])->json('GET', '/api/v1/chefs/' . self::CODE . '/dishes');


        $response->assertStatus(200);
    }
}
