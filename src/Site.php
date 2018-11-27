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
     * Command runner
     *
     * @var string
     */
    protected $commandRunner = SystemCommand::class;

    /**
     * Add a new command
     *
     * @param  string $command
     * @return Site
     */
    protected function command($command) {
        
        $runner = $this->commandRunner;
        
        $this->commands[] = new $runner($command);
    }
    
    /**
     * Set the command runner class
     *
     * @param string $runner
     */
    public function setCommandRunner($runner) {
        
        $this->commandRunner = $runner;
        
        return $this;
    }
    
    /**
     * Deploy
     *
     * @return array
     */
    public function deploy() {
    
        $results = [];
        
        return collect($this->commands)->map(function($command) {
            return $command->execute();
        })->toArray();
    }
}