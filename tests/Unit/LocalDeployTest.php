<?php

namespace stekel\LaravelDeploy\Tests;

use stekel\LaravelDeploy\DeployManager;
use stekel\LaravelDeploy\Tests\Stubs\SampleSite;
use stekel\LaravelDeploy\Tests\TestCase;
use stekel\LaravelDeploy\Shell;
use Mockery;

class LocalDeployTest extends TestCase {
    
    /** @test **/
    public function can_deploy_a_sample_site_with_a_single_command() {
        
        $shell = Mockery::mock(Shell::class);
        
        $shell->shouldReceive('system')
            ->once()
            ->with('git pull')
            ->andReturn('Repository updated successfully.');
        
        $deploy = (new DeployManager([
            'sample' => new SampleSite($shell),
        ]));
        
        $results = $deploy->site('sample')->locally();
        
        $this->assertEquals(['Repository updated successfully.'], $results);
    }
}