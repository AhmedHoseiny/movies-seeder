<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Hoseiny\Movies\Repositories\MovieDataSourceRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_seed_movies()
    {
        $mockingBody = [
            "page" => 1,
            "total_results" => 10000,
            "total_pages" => 500,
            "results" => [
                [
                    'adult' => false,
                    'backdrop_path' => '/inJjDhCjfhh3RtrJWBmmDqeuSYC.jpg',
                    'genre_ids' =>
                        [
                            0 => 28,
                            1 => 878,
                        ],
                    'id' => 399566,
                    'original_language' => 'en',
                    'original_title' => 'Godzilla vs. Kong',
                    'overview' => 'In a time when monsters walk the Earth, humanity’s fight for its future sets Godzilla and Kong on a collision course that will see the two most powerful forces of nature on the planet collide in a spectacular battle for the ages.',
                    'popularity' => 10755.513,
                    'poster_path' => '/pgqgaUx1cJb5oZQQ5v0tNARCeBp.jpg',
                    'release_date' => '2021-03-24',
                    'title' => 'Godzilla vs. Kong',
                    'video' => false,
                    'vote_average' => 8.4,
                    'vote_count' => 4014,
                ]
            ]
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $someClass = new MovieDataSourceRepository($client);

        $response = $someClass->syncMovies();
        $this->assertTrue($response);
        $this->assertDatabaseHas('movies', [
            "id" => 1,
            "movie_id" => 399566,
            "popularity" => 10755.513,
            "vote_count" => 4014,
            "video" => false,
            "poster_path" => "/pgqgaUx1cJb5oZQQ5v0tNARCeBp.jpg",
            "adult" => false,
            "backdrop_path" => "/inJjDhCjfhh3RtrJWBmmDqeuSYC.jpg",
            "original_language" => "en"
        ]);

    }

    /** @test */
    public function test_list_movies()
    {
        $response = $this->get('/movies');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data',
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]);
    }
}
