<?php
namespace Libreria;
use \Libreria\Interfaces\Server;

class Estadistica implements Server{
    private $server;
    private $count=0;
    public function __construct($server){
        $this->server=$server;
        
    }

    public function call(){
        $this->count++;
        return $this->server->call();
    }
    public function count(){
        return $this->count;
    }

    public function getName(){

        return $this->server->getName();
    }
}