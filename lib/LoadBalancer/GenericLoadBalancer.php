<?php

namespace Libreria\LoadBalancer;
use \Libreria\Interfaces\Server;
use \Libreria\Interfaces\LoadBalancer;

class GenericLoadBalancer implements Server, LoadBalancer{

    private $name;
    private $servers=array();
    private $serverKeys=array();
    private $numberOfCalls=0;
    private $strategy;

    public function __construct($name,$strategy){
        $this->name=$name;
        $this->strategy=$strategy;

    }

    public function addServer(Server $server){
        if (!empty($this->servers[$server->getName()])){
            return False;
        }
        $this->servers[$server->getName()]=$server;
        // $this->serverKeys[]=$server->getname();//LINEA PARA ROUNDROBIN
        // $this->servers[$server->getname()]=$server;//LINEA PARA ROUNDROBIN
            
        return True;
    }
    

    public function removeServer(String $serverName){
    //     if (in_array($serverName,$this->serverKeys)){
    //         unset($this->servers[$serverName]);
    //         // $this->serverKeys=array();
    //         // foreach ($this->servers as $server){
    //         //     $this->serverKeys[]=$server->getname();
    //         // }
    //         return True;
    //     }else{
    //         return False;  // DE ACA PARA ARRIBA SON LINEAS DEL ROUNDROBIN
    //     }
    // }
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
        $s=$this->strategy->pick($this->servers);
        return $s->call();
        
    }
}