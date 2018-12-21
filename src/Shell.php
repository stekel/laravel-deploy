<?php

namespace stekel\LaravelDeploy;

class Shell {
    
    /**
     * System call
     *
     * @return string
     */
    public function system($command) {
    
        return system($command);
    }
}