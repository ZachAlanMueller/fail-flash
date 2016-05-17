<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\helpers;

class updateSummoner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateSummoner {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update a summoner';

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
     * @return mixed
     */
    public function handle()
    {
        $arguments = $this->argument();
        updateSummoner($arguments[0]);
    }
}
