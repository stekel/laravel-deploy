<?php

namespace stekel\LaravelDeploy\Tests;

use Mockery;
use phpseclib3\Net\SSH2;
use stekel\LaravelDeploy\Shell;
use stekel\LaravelDeploy\Tests\Stubs\SampleSite;

class SSHDeployTest extends TestCase
{
    /** @test **/
    public function can_deploy_a_sample_site_via_ssh_using_username_password_auth()
    {
        $ssh = Mockery::mock(SSH2::class);

        $ssh->shouldReceive('login')
            ->once()
            ->with('username', 'password')
            ->andReturn(true);
        $ssh->shouldReceive('exec')
            ->once()
            ->with('git pull')
            ->andReturn("Repository updated successfully.\n");

        $site = new SampleSite(new Shell(), $ssh);

        $site->viaSSH();

        $this->assertEquals([
            [
                'command' => 'git pull',
                'result' => 'Repository updated successfully.',
            ],
        ], $site->output());
    }
}
