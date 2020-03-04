<?php
namespace Libreria\Servers;
use \Libreria\Interfaces\Server as Server;

class ServerRedirect implements Server{
    private $name;
    public function __construct($name){
        $this->name=$name;
    }
    function getName(){
        return $this->name;
    }
    function call(){
        return 300;
    }
}