<?php

namespace Tests\Feature;

use Faker\Factory as FakerFactory;
use Tests\TestCase;

class AddCommentTest extends TestCase
{
    public function testAddComment(){
        $token = $this->getUserToken();
        $faker = FakerFactory::create();

        $tours = $this->get('api/tour', [ 'Authorization' => 'Bearer ' . $token ]);
        $tour = $this->get("api/tour/{$tours[0]['id']}", [ 'Authorization' => 'Bearer ' . $token ]);

        $commentBody = [
            'commentContent' => $faker->realText(),
            'mark'=>$faker->numberBetween(0, 5)
        ];

        $addCommentResponse = $this->post(
            "api/tour/{$tours[0]['id']}/addComment",
            $commentBody,
            [ 'Authorization' => 'Bearer ' . $token ]
        );

        $updatedTour = $this->get("api/tour/{$tours[0]['id']}", [ 'Authorization' => 'Bearer ' . $token ]);

        self::assertGreaterThan(count($tour['comments']), count($updatedTour['comments']));

        $addedComment = $updatedTour['comments'][count($updatedTour['comments'])-1];

        self::assertEquals($commentBody['commentContent'], $addedComment['content']);
        self::assertEquals($commentBody['mark'], $addedComment['mark']);
    }

    //TODO delete
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
