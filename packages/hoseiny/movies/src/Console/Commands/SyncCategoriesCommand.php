<?php

namespace Hoseiny\Movies\Console\Commands;

use Hoseiny\Movies\Repositories\EloquentCategoryRepository;
use Illuminate\Console\Command;

class SyncCategoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed recently and top rated movies categories';

    public $categoryRepository;

    /**
     * SyncCategoriesCommand constructor.
     * @param EloquentCategoryRepository $categoryRepository
     */
    public function __construct(EloquentCategoryRepository $categoryRepository)
    {
        parent::__construct();
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->categoryRepository->syncCategories();
    }
}
