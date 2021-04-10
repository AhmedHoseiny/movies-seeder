<?php

namespace Hoseiny\Movies\Console\Commands;

use Hoseiny\Movies\Repositories\MovieDataSourceRepository;
use Illuminate\Console\Command;

class SyncMoviesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed recently and top rated movies';

    public $movieRepository;

    /**
     * SyncCategoriesCommand constructor.
     * @param MovieDataSourceRepository $movieRepository
     */
    public function __construct(MovieDataSourceRepository $movieRepository)
    {
        parent::__construct();
        $this->movieRepository = $movieRepository;
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->movieRepository->syncMovies();
        return true;
    }
}
