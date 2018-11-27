<?php

namespace stekel\LaravelDeploy\Tests;

use stekel\LaravelDeploy\DeployManager;
use stekel\LaravelDeploy\Tests\Stubs\SampleSite;
use stekel\LaravelDeploy\Tests\TestCase;

class LocalDeployTest extends TestCase {
    
    /** @test **/
    public function can_throw_an_exception_if_the_site_method_doesnt_exist() {
        
        $deploy = (new DeployManager([
            'sample' => SampleSite::class,
        ]))->fake();
        
        $deploy->site('sample')->locally();
        
        $this->assertEquals([
            'git pull'
        ], $deploy->getResults());
    }
}