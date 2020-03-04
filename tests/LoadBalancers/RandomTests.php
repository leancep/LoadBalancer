<?php
namespace LBTest\LoadBalancers;

use \PHPUnit\Framework\TestCase;
class RandomTests extends TestCase{

    public function testLlamaAUnSv(){
        $lb= new \Libreria\LoadBalancer\GenericLoadBalancer("RANLB",
        new \Libreria\LoadBalancer\PickStrategy\RandomStrategy);
        $sv= new \Libreria\Servers\ServerOK("SOK");
        $sv2= new \Libreria\Servers\ServerCaido("down");
        $lb-> addServer($sv2);
        $this->assertTrue($lb->addServer($sv));
        // $this->assertEquals(0, $lb->call());
    }

    public function testListServer(){
        $lb= new \Libreria\LoadBalancer\GenericLoadBalancer("RANLB",
        new \Libreria\LoadBalancer\PickStrategy\RandomStrategy);
        $sv= new \Libreria\Servers\ServerOK("Ok1");
        $lb->addServer($sv);
        $sv2= new \Libreria\Servers\ServerNotFound("NotF");
        $lb->addServer($sv2);

        $this-> assertContains($sv,$lb->getList());
        $this-> assertContains($sv2,$lb->getList());
    }

    public function testLlamaSvYBorra1(){
        $lb= new \Libreria\LoadBalancer\GenericLoadBalancer("RANLB",
        new \Libreria\LoadBalancer\PickStrategy\RandomStrategy);
        $sv= new \Libreria\Servers\ServerOK("S1OK");
        $lb-> addServer($sv);
        $sv= new \Libreria\Servers\ServerCaido("down");
        $lb-> addServer($sv);
        $sv= new \Libreria\Servers\ServerOk("S1OK");
        $lb-> addServer($sv);
        $sv= new \Libreria\Servers\ServerOK("S1OK");
        $lb-> addServer($sv);
        $sv= new \Libreria\Servers\ServerCaido("down");
        $lb-> addServer($sv);
        $sv= new \Libreria\Servers\ServerOk("S1OK");
        $lb-> addServer($sv);
        // $this->assertEquals(0, $lb->call());
        // $this->assertEquals(0, $lb->call());
        // $this->assertEquals(200, $lb->call());

        $lb->removeServer("S10K");
        $this->assertEquals(0, $lb->call());

    }
    public function testLlamandoCuandoNoHaySv(){
        $lb= new \Libreria\LoadBalancer\GenericLoadBalancer("RANLB",
        new \Libreria\LoadBalancer\PickStrategy\RandomStrategy);
        try {
            $lb->call();
        } catch (\Exception $e){
            $this->assertTrue(True);
        }
    }
}
