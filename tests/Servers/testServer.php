<?php
namespace LBTest\Servers;

use PHPUnit\Framework\TestCase;

final class LoadBalancerTests extends TestCase{
    public function testAndaTodo(){
        $this->assertTrue(True);
    }
    public function testServerOk(){
        $server= new \Libreria\Servers\ServerOK("Servidor1");
        $this->assert(200,$server->call());
    }
}