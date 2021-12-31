<?php

namespace Tests\Feature;

use Tests\TestCase;
use Faker\Factory as FakerFactory;

class RegistrationAndLoginTest extends TestCase
{

    public function testRegistrateUserAndLogin()
    {
        $faker = FakerFactory::create();

        $regRequest = [
            'login' => $faker->email(),
            'password' => $faker->password(6),
            'firstname' => $faker->firstName(),
            'lastname' => $faker->lastName()
        ];

        $regResponse = $this->postJson(
            'api/registration',
            $regRequest
        );

        $regResponse->assertStatus(201);

        $loginRequest = [
            'login' => $regRequest['login'],
            'password' => $regRequest['password']
        ];

        $loginResponse = $this->postJson(
            'api/login',
            $loginRequest
        );

        $loginResponse->assertStatus(200);
    }
}
