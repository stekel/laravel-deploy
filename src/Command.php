<?php

namespace stekel\LaravelDeploy;

abstract class Command {
    
    /**
     * Command string
     *
     * @var string
     */
    protected $command;
    
    /**
     * Construct
     *
     * @param string $command
     */
    public function __construct(string $command) {
        
        $this->command = $command;
    }
    
    /**
     * Execute
     *
     * @return void
     */
    abstract public function execute();
}