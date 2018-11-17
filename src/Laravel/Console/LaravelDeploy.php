<?php

namespace stekel\LaravelDeploy\Laravel\Console;

use Illuminate\Console\Command;

class LaravelDeploy extends Command {
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stekel:deploy
                            {site? : The site to deploy}
                            ';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy a given site.';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        
        
    }
}
