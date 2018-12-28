<?php

namespace stekel\LaravelDeploy\Tests;

use stekel\LaravelDeploy\Shell;
use stekel\LaravelDeploy\Tests\Stubs\SampleSite;
use stekel\LaravelDeploy\Tests\TestCase;
use Mockery;
use phpseclib\Net\SSH2;

class SSHDeployTest extends TestCase {
    
    /** @test **/
    public function can_deploy_a_sample_site_via_ssh_using_username_password_auth() {
        
        $ssh = Mockery::mock(SSH2::class);
        
        $ssh->shouldReceive('login')
            ->once()
            ->with('username', 'password')
            ->andReturn(true);
        $ssh->shouldReceive('exec')
            ->once()
            ->with('git pull')
            ->andReturn([
                'Repository updated successfully.',
            ]);
        
        $site = new SampleSite(new Shell(), $ssh);
        
        $site->viaSSH();
        
        $this->assertEquals(['Repository updated successfully.'], $site->output());
    }
}