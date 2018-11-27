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
}