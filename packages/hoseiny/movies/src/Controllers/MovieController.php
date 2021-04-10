<?php

namespace Hoseiny\Movies\Controllers;

use App\Http\Controllers\Controller;
use Hoseiny\Movies\Repositories\EloquentMovieRepository;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public $movieRepository;

    public function __construct(EloquentMovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function index(Request $request)
    {
        return $this->movieRepository->all($request->all());
    }
}
