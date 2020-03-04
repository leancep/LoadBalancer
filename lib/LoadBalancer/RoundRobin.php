<?php
namespace Libreria\LoadBalancer;
use \Libreria\Interfaces\Server;
use \Libreria\Interfaces\LoadBalancer;

class RoundRobin implements Server{
    private $name;
    private $servers=array();
    private $serverKeys=array();
    private $numberOfCalls=0;
    private $estadistica=0;
    
    public function __construct($name, $LBStrategy){
        $this->name=$name;
        $LBStrategy=new \Libreria\RoundRobinStrategy;

    }

    function addServer(Server $server){
        if (in_array($server,$this->servers)){
        return False;
        } else{
            $this->serverKeys[]=$server->getname();
            $this->servers[$server->getname()]=$server;
            return True;
        }
    }
    function removeServer(String $serverName){
        if (in_array($serverName,$this->serverKeys)){
            unset($this->servers[$serverName]);
            $this->serverKeys=array();
            foreach ($this->servers as $server){
                $this->serverKeys[]=$server->getname();
            }
            return True;
        }else{
            return False;
        }
    }
    public function getList(){
        return $this->servers;
    }
    
    function getName(){
        return $this->name;
    }
    // function call(){
        // if (empty($this->servers)){
        //     throw new \Exception();
        // }
        // $key= $this->serverKeys[$this->numberOfCalls];
        // $server= $this->servers[$key];
        // $this->numberOfCalls+=1;
        
        // if ($this->numberOfCalls>= count($this->servers)){
        //     $this->numberOfCalls=0;
        // }
    function call(){
        $s=$this->strategy->pick($this->servers);
        return $s->call();
    }
}




//Codigos
// 200= ok
// 300= redirect
// 400= not found
// 500= error
// 0=caido
//RoundRobin (1 a 1)- Random(Array_random) - Priority - 
//Call llama a un servidor
// 2 server no pueden tener el mismo nombre
//removeServer(string $serverName);
// __construct (string $name)
//addServer return Boolean
// getName return String
// Call() return int
// 