<?php
namespace Libreria\LoadBalancer\PickStrategy;
use \Libreria\Interfaces\LBStrategy;

class RandomStrategy implements LBStrategy{
    public function pick(array $servers){
        
        $key=array_rand($servers);

    return $servers[$key];
    }
}