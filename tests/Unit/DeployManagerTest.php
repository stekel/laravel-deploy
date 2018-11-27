<?php

namespace stekel\LaravelDeploy\Tests;

use stekel\LaravelDeploy\DeployManager;
use stekel\LaravelDeploy\Tests\Stubs\SampleSite;
use stekel\LaravelDeploy\Tests\TestCase;

class DeployManagerTest extends TestCase {
    
    /** @test **/
    public function can_throw_an_exception_if_the_site_doesnt_exist() {
        
        $deploy = new DeployManager([]);
        
        $this->expectException(\Exception::class);
        
        $deploy->site('sample')->locally();
    }
    
    /** @test **/
    public function can_throw_an_exception_if_the_site_is_not_set() {
        
        $deploy = new DeployManager([]);
        
        $this->expectException(\Exception::class);
        
        $deploy->locally();
    }
    
    /** @test **/
    public function can_throw_an_exception_if_the_site_method_doesnt_exist() {
        
        $deploy = new DeployManager([
            'sample' => SampleSite::class,
        ]);
        
        $this->expectException(\Exception::class);
        
        $deploy->site('sample')->unknownDeployMethod();
    }
}