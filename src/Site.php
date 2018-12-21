<?php

namespace stekel\LaravelDeploy;

abstract class Site {
    
    /**
     * Commands
     *
     * @var array
     */
    protected $commands;
    
    /**
     * Shell
     *
     * @var string
     */
    protected $shell;
    
    /**
     * Construct
     *
     * @param string|Shell $shell
     */
    public function __construct($shell=Shell::class) {
        
        $this->shell = is_string($shell) ? new $shell() : $shell;
    }
    
    /**
     * Add a new command
     *
     * @param  string $command
     * @return Site
     */
    protected function command($command) {
        
        $this->commands[] = $command;
    }
    
    /**
     * Deploy
     *
     * @return array
     */
    public function deploy() {
    
        return collect($this->commands)->map(function($command) {
            return $this->shell->system($command);
        })->toArray();
    }
}