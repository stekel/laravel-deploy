<?php

namespace stekel\LaravelDeploy;

class DeployManager {
    
    /**
     * Current site
     *
     * @var Site
     */
    protected $currentSite;
    
    /**
     * Sites
     *
     * @var array
     */
    protected $sites;
    
    /**
     * Construct
     *
     * @param array $sites
     */
    public function __construct(array $sites) {
        
        $this->sites = $sites;
    }
    
    /**
     * Set the site
     *
     * @param  string $name
     * @return DeployManager
     */
    public function site($name) {
    
        if (! isset($this->sites[$name])) {
            
            throw new \Exception('No site "'.$name.'" configured.');
        }
            
        $class = $this->sites[$name];
        
        $this->currentSite = is_string($class) ? new $class(new Shell()) : $class;
        
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
        
        if (! ($this->currentSite instanceof Site)) {
            
            throw new \Exception('No site set.');
        }
        
        if (method_exists($this->currentSite, $method)) {
            
            $this->currentSite->$method();
            
            return $this->currentSite->deploy();
        }
        
        throw new \Exception('Method '.$method.' does not exist on '.get_class($this->currentSite));
    }
}