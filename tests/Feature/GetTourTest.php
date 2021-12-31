<?php

namespace Tests\Feature;


use Faker\Factory as FakerFactory;
use Tests\TestCase;

class GetTourTest extends TestCase
{
    public function testGetTour()
    {
        $token = $this->getUserToken();

        $tours = $this->get('api/tour', [ 'Authorization' => 'Bearer ' . $token ]);

        $tour = $this->get('api/tour/' . $tours[0]['id'], [ 'Authorization' => 'Bearer ' . $token ]);

        self::assertEquals(
            [
                'id' => $tours[0]['id'],
                'title' => $tours[0]['title'],
                'description' => $tours[0]['description'],
            ],
            [
                'id' => $tour['id'],
                'title' => $tour['title'],
                'description' => $tour['description'],
            ]
        );
    }

    private function getUserToken()
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

        $loginRequest = [
            'login' => $regRequest['login'],
            'password' => $regRequest['password']
        ];

        return $this->postJson(
            'api/login',
            $loginRequest
        )['token'];
    }
}
