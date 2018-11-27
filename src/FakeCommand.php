<?php

namespace stekel\LaravelDeploy;

class FakeCommand extends Command {
    
    /**
     * Execute
     *
     * @return void
     */
    public function execute() {
        
        return $this->command;
    }
}