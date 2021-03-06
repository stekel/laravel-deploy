<?php

namespace stekel\LaravelDeploy;

use Closure;
use phpseclib\Crypt\RSA;
use phpseclib\Net\SSH2;

abstract class Site {

    /**
     * Commands
     *
     * @var array
     */
    protected $commands;

    /**
     * Shell
     *
     * @var string
     */
    protected $shell;

    /**
     * SSH
     *
     * @var SSH2
     */
    protected $ssh;

    /**
     * Output
     *
     * @var array
     */
    protected $output = [];

    /**
     * Construct
     *
     * @param Shell $shell
     * @param SSH2  $ssh
     */
    public function __construct(Shell $shell, SSH2 $ssh=null) {

        $this->shell = $shell;
        $this->ssh = $ssh;
    }

    /**
     * Add a new command
     *
     * @param  string $command
     * @return void
     */
    protected function command($command) {

        $this->commands[] = $command;
    }

    /**
     * SSH
     *
     * @param  string  $url
     * @param  string  $username
     * @param  string  $password
     * @param  Closure $callback
     * @return void
     */
    protected function ssh($url, $username, $password, Closure $callback) {

        $connection = is_null($this->ssh) ? new SSH2($url) : $this->ssh;

        // define('NET_SSH2_LOGGING', SSH2::LOG_COMPLEX);

        if (! $connection->login($username, $password)) {

            // print_r($connection->getLog());
            // print_r($connection->getErrors());
            die('Connection failed.');
        }

        $ssh = new SSH($connection);

        $callback($ssh);

        $this->output = $ssh->output();
    }

    /**
     * SSH w/ key
     *
     * @param  string  $url
     * @param  string  $username
     * @param  string  $keyPath
     * @param  Closure $callback
     * @return void
     */
    protected function sshWithKey($url, $username, $keyPath, Closure $callback) {

        $connection = is_null($this->ssh) ? new SSH2($url) : $this->ssh;
        $key = new RSA();
        $key->loadKey(file_get_contents($keyPath));

        if (! $connection->login($username, $key)) {
            exit('Login Failed');
        }

        $ssh = new SSH($connection);

        $callback($ssh);

        $this->output = $ssh->output();
    }

    /**
     * Output
     *
     * @return string
     */
    public function output() {

        return $this->output;
    }

    /**
     * Deploy
     *
     * @return array
     */
    public function deploy() {

        $output = collect($this->commands)->map(function($command) {
            return $this->shell->system($command);
        })->toArray();

        return array_merge($this->output, $output);
    }
}
