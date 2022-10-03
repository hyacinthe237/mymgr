<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testSignupMissingRequiredParams () 
    {
        $response = $this->postJson('/api/v1/signup', [
            'username' => 'eddythedove'
        ]);

        $response->assertStatus(400);
    }


    public function testSignupCustomerSuccessfull () 
    {
        $response = $this->postJson('/api/v1/signup', [
            'username'         => 'eddythedove',
            'firstname'        => 'Eddy',
            'lastname'         => 'Ella',
            'mobile'           => '0422332233',
            'email'            => 'eddy@izytechgroup.com',
            'password'         => 'secret',
            'password_confirm' => 'secret',
            'country_id'       => 14,
            'role_id'          => 3,
            'middle_name'      => '',
            'address'          => '22 Jump St',
            'suburb'           => 'Sydney',
            'state'            => 'nsw',
            'postcode'         => '2000',
            'card_last_digits' => '4323',
            'card_expiry'      => '09/22',
        ]);

        $response->assertStatus(201);
    }



    public function testSignupCustomerDuplicateUsername () 
    {
        $this->postJson('/api/v1/signup', [
            'username'         => 'eddythedove',
            'firstname'        => 'Eddy',
            'lastname'         => 'Ella',
            'mobile'           => '0422332233',
            'email'            => 'eddy@izytechgroup.com',
            'password'         => 'secret',
            'password_confirm' => 'secret',
            'country_id'       => 14,
            'role_id'          => 3
        ]);

        $response = $this->postJson('/api/v1/signup', [
            'username'         => 'eddythedove',
            'firstname'        => 'Eddy',
            'lastname'         => 'Ella',
            'mobile'           => '0422332233',
            'email'            => 'user@izytechgroup.com',
            'password'         => 'secret',
            'password_confirm' => 'secret',
            'country_id'       => 14,
            'role_id'          => 3,
            'middle_name'      => '',
            'address'          => '22 Jump St',
            'suburb'           => 'Sydney',
            'state'            => 'nsw',
            'postcode'         => '2000',
            'card_last_digits' => '4323',
            'card_expiry'      => '09/22',
        ]);

        $response->assertStatus(400);
    }


    public function testSignupCustomerDuplicateEmail () 
    {
        $this->postJson('/api/v1/signup', [
            'username'         => 'eddythedove',
            'firstname'        => 'Eddy',
            'lastname'         => 'Ella',
            'mobile'           => '0422332233',
            'email'            => 'eddy@izytechgroup.com',
            'password'         => 'secret',
            'password_confirm' => 'secret',
            'country_id'       => 14,
            'role_id'          => 3
        ]);

        $response = $this->postJson('/api/v1/signup', [
            'username'         => 'armelpineur',
            'firstname'        => 'Eddy',
            'lastname'         => 'Ella',
            'mobile'           => '0422332233',
            'email'            => 'eddy@izytechgroup.com',
            'password'         => 'secret',
            'password_confirm' => 'secret',
            'country_id'       => 14,
            'role_id'          => 3,
            'middle_name'      => '',
            'address'          => '22 Jump St',
            'suburb'           => 'Sydney',
            'state'            => 'nsw',
            'postcode'         => '2000',
            'card_last_digits' => '4323',
            'card_expiry'      => '09/22',
        ]);

        $response->assertStatus(400);
    }
}
