<?php

namespace Yjtec\Repo\Commands;

use Illuminate\Console\Command;
use Yjtec\Repo\RepoManifest;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rep:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'publish the respository';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->laravel->make(RepoManifest::class)->build();
    }
}
