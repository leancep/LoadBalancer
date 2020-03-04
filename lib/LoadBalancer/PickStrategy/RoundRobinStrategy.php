<?php
namespace Libreria\LoadBalancer\PickStrategy;
use \Libreria\Interfaces\LBStrategy;

class RoundRobinStrategy implements LBStrategy{
    private $count=0;
    public function pick(array $servers){
        $servers= array_values($servers);
        
        // $key= $serverKeys[$numberOfCalls];
        // $server= $servers[$key];
        // $numberOfCalls+=1;
        $server=$servers[$this->count % count($servers)];
        $this->count++;
        // if ($numberOfCalls>= count($servers)){
        //     $numberOfCalls=0;
        // }
        return $server;
    }
}
