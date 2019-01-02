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
                            {environment? : The environment on the given site to deploy}
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
        
        if (! $this->argument('site') || ! $this->argument('environment')) {
            
            $this->line('');
            $this->line('Please use a site identifier from below as the first argument.');
            
            $sites = collect(app('deploy')->sites())->map(function($environments, $site) {
                return [
                    'identifier' => $site,
                    'environments' => implode("\n", $environments),
                ];
            })->toArray();
            
            $this->table(['Site Identifier', 'Environments'], $sites);
            $this->line('');
            
            return;
        }
        
        $environment = $this->argument('environment');
        
        app('deploy')->site($this->argument('site'))->$environment();
        
        $this->table(['Command', 'Result'], collect(app('deploy')->output())->map(function($line) {
            return array_wrap($line);
        }));
    }
}
