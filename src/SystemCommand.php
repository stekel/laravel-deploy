<?php

namespace stekel\LaravelDeploy;

class SystemCommand extends Command {
    
    /**
     * Execute
     *
     * @return void
     */
    public function execute() {
    
        return system($this->command);
    }
}