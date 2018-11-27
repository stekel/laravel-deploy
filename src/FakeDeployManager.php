<?php

namespace stekel\LaravelDeploy;

class FakeDeployManager extends DeployManager {
    
    /**
     * Result array
     *
     * @var array
     */
    protected $results = [];
    
    /**
     * Set the site
     *
     * @param  string $name
     * @return DeployManager
     */
    public function site($name) {
        
        parent::site($name);
        
        $this->currentSite->setCommandRunner(FakeCommand::class);
        
        return $this;
    }
    
    /**
     * Magic call method
     *
     * @param  string $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters) {
        
        $site = parent::__call($method, $parameters);
        
        $this->results = $site->deploy();
        
        return $this;
    }
    
    /**
     * Get results
     *
     * @return array
     */
    public function getResults() {
    
        return $this->results;
    }
}