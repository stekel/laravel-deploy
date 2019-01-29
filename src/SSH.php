<?php

namespace stekel\LaravelDeploy;

use phpseclib\Net\SSH2;

class SSH
{
    
    /**
     * Connection
     *
     * @var SSH2
     */
    protected $connection;
    
    /**
     * Output
     *
     * @var array
     */
    protected $output = [];
    
    /**
     * Construct
     *
     * @param SSH2 $connection
     */
    public function __construct(SSH2 $connection)
    {
        $this->connection = $connection;
    }
    
    /**
     * Run a command over the ssh connection
     *
     * @param  string $command
     * @return void
     */
    public function command($command)
    {
        $this->output = array_merge($this->output, [
            [
                'command' => $command,
                'result' => trim($this->connection->exec($command), "\n")
            ]
        ]);
    }
    
    /**
     * Get the entire output array
     *
     * @return array
     */
    public function output()
    {
        return $this->output;
    }
}
