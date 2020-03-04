<?php
namespace Libreria\LoadBalancer;
use \Libreria\Interfaces\Server;
use \Libreria\Interfaces\LoadBalancer;

class Random implements Server, LoadBalancer{

    private $name;
    private $servers=array();

    public function __construct($name){
        $this->name=$name;

    }

    public function addServer(Server $server){
        if (!empty($this->servers[$server->getName()])){
            return False;
        }
        $this->servers[$server->getName()]=$server;
        return True;
    }

    public function removeServer(String $serverName){
        if (empty($this->servers[$serverName])){
            return False;
        }
        unset($this->servers[$serverName]);
        return True;
        }
    
    public function getList(){
        return $this->servers;
    }
    public function getName(){
        return $this->name;
    }
    public function call(){
        if (empty($this->servers)){
            throw new \Exception();
        }
        $s=new \Libreria\PickStrategy\RandomStrategy();
        $s->pick($this->servers);
        return $s->call();
        // $key=array_rand($this->servers);
        // return $this->servers[$key]->call();
    }
}

