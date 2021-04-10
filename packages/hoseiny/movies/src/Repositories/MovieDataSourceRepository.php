<?php

namespace Hoseiny\Movies\Repositories;

use GuzzleHttp\Client;
use Hoseiny\Movies\Repositories\Contracts\RepositoryInterface;

class MovieDataSourceRepository implements RepositoryInterface
{
    public $client;

    /**
     * EloquentMovieRepository constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    private function getMovies($endPoint): array
    {
        $movies = [];
        for ($i = 1; $i <= config('movie.num_of_pages'); $i++) {
            $url = config('movie.movie_url') . "/movie/$endPoint?api_key=" . config('movie.api_key') . '&page=' . $i;
            $response = $this->client->request('GET', $url);
            $results = json_decode($response->getBody())->results;
            $movies = array_merge($movies, $results);
        }

        return $movies;
    }

    public final function getTopRatedMovies(): array
    {
        return $this->getMovies('top_rated');
    }

    public final function getLatestMovies(): array
    {
        return $this->getMovies('popular');
    }

    public function syncMovies(): bool
    {
        $latestMovies = $this->getLatestMovies();
        $topRatedMovies = $this->getTopRatedMovies();
        $movies = array_merge($latestMovies, $topRatedMovies);
        app(EloquentMovieRepository::class)->insert($movies);
        return true;
    }
}
