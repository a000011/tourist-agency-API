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

    public function testGetTours(){
        $token = $this->getUserToken();

        $tours = $this->get('api/tour', [ 'Authorization' => 'Bearer ' . $token ]);

        foreach ($tours->original as $tour){
            self::assertNotEmpty($tour['id']);
            self::assertNotEmpty($tour['title']);
            self::assertNotEmpty($tour['description']);
            self::assertNotEmpty($tour['img']);
            self::assertNotEmpty($tour['updated_at']);
            self::assertNotEmpty($tour['created_at']);
        }
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

    public function testBreakeTest(){
        self::assertTrue(false);
    }
}
