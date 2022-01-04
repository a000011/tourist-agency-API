<?php

namespace Tests\Feature;

use Faker\Factory as FakerFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CreateAndDeleteTourTest extends TestCase
{
    private const ADMIN_LOGIN = 'testAdmin';

    public function testCreateTour()
    {
        $adminToken = $this->getAdminToken();
        $faker = FakerFactory::create();

        $testTour = [
            'title' => $faker->realText(12),
            'description' => $faker->realText(),
            'img' => 'testImg'
        ];

        $result = $this->post(
            'api/tour/create',
            $testTour,
            ['Authorization' => 'Bearer ' . $adminToken]
        );

        $tour = $this->get('api/tour/' . $result['id'], ['Authorization' => 'Bearer ' . $adminToken]);
        $this->assertTwoTours($testTour, $tour);
    }

    public function testDeleteTour()
    {
        $adminToken = $this->getAdminToken();

        $tours = $this->get('api/tour', [ 'Authorization' => 'Bearer ' . $adminToken ])->original->toArray();
        $randomTour = $tours[array_rand($tours)];

        $this->delete('api/tour/' . $randomTour['id'], [], [ 'Authorization' => 'Bearer ' . $adminToken ]);

        $tours = $this->get('api/tour', [ 'Authorization' => 'Bearer ' . $adminToken ])->original->toArray();
        $deletedTour = array_filter($tours, function ($item) use ($randomTour){
           return $item['id'] === $randomTour['id'];
        });

        self::assertEquals($deletedTour, []);
    }

    private function getAdminToken(): string
    {
        $loginRequest = [
            'login' => self::ADMIN_LOGIN,
            'password' => self::ADMIN_LOGIN
        ];

        return $this->postJson(
            'api/login',
            $loginRequest
        )['token'];
    }

    private function assertTwoTours(array $expectedTour, TestResponse $actualTour): void
    {
        self::assertEquals($expectedTour['title'], $actualTour['title']);
        self::assertEquals($expectedTour['description'], $actualTour['description']);
        self::assertEquals($expectedTour['img'], $actualTour['img']);
    }
}
