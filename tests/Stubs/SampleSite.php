<?php

namespace stekel\LaravelDeploy\Tests\Stubs;

use stekel\LaravelDeploy\Site;

class SampleSite extends Site {
    
    /**
     * Local deploy
     *
     * @return void
     */
    public function locally() {
    
        $this->command('git pull');
    }
    
    /**
     * SSH deploy
     *
     * @return void
     */
    public function viaSSH() {
    
        $this->ssh('samplehost.com', 'username', 'password', function($connection) {
            
            $connection->command('git pull');
        });
    }
}