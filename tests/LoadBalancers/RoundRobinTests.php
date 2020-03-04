<?php
namespace LBTest\LoadBalancers;

use \PHPUnit\Framework\TestCase;

class RoundRobinTests extends TestCase {
    public function testLlamaAUnServidor(){
        $lb= new \Libreria\LoadBalancer\GenericLoadBalancer("LB1",
    new \Libreria\LoadBalancer\PickStrategy\RoundRobinStrategy);
        $server= new \Libreria\Servers\ServerOK("S1");
        $lb->addServer($server);
        $this->assertEquals(200, $lb->call());
    }


    public function testLlamaADosServidores(){
    $lb= new \Libreria\LoadBalancer\GenericLoadBalancer("LB1",
    new \Libreria\LoadBalancer\PickStrategy\RoundRobinStrategy);
    $server= new \Libreria\Servers\ServerOK("S1");
    $lb->addServer($server);
    $server1= new \Libreria\Servers\ServerFail("F1");
    $lb-> addServer ($server1);
    $this->assertEquals(200, $lb->call());
    $this->assertEquals(500, $lb->call());
    $this->assertEquals(200, $lb->call());
    $this->assertEquals(500, $lb->call());
    }

    public function testLlamaADosServidoresyBorra1(){
        $lb= new \Libreria\LoadBalancer\GenericLoadBalancer("LB1",
        new \Libreria\LoadBalancer\PickStrategy\RoundRobinStrategy);
        $server= new \Libreria\Servers\ServerOK("S1");
        $lb->addServer($server);
        $server= new \Libreria\Servers\ServerFail("F1");
        $lb-> addServer ($server);
        $this->assertEquals(200, $lb->call());
        $this->assertEquals(500, $lb->call());
        $this->assertEquals(200, $lb->call());
        $this->assertEquals(500, $lb->call());
    
        $this->assertTrue($lb->removeServer("S1"));
        $this->assertEquals(500, $lb->call());
        $this->assertEquals(500, $lb->call());
        $this->assertEquals(500, $lb->call());
        $this->assertEquals(500, $lb->call());
        }

     public function testLlamandoCuandoNoHaySv(){
         $lb=new \Libreria\LoadBalancer\GenericLoadBalancer("LB1",
         new \Libreria\LoadBalancer\PickStrategy\RoundRobinStrategy);
         try {
             $lb->call();
         } catch (\Exception $e){
             $this->assertTrue(True);
         }
        
    }
     public function testBalancerInBalancer(){
        $lb=new \Libreria\LoadBalancer\GenericLoadBalancer("LB1",
         new \Libreria\LoadBalancer\PickStrategy\RoundRobinStrategy);
        $lb1=new \Libreria\LoadBalancer\GenericLoadBalancer("LB1",
        new \Libreria\LoadBalancer\PickStrategy\RoundRobinStrategy);
        $server= new \Libreria\Servers\ServerOK("S1");
        // $lb->addServer($lb1);
        $this-> assertTrue($lb->addServer($lb1));
     }
     public function testLlamadasRoundRobin(){
        $lb=new \Libreria\LoadBalancer\GenericLoadBalancer("LBMayor",
        new \Libreria\LoadBalancer\PickStrategy\RoundRobinStrategy);
        $lb1=new \Libreria\LoadBalancer\GenericLoadBalancer("LB1",
        new \Libreria\LoadBalancer\PickStrategy\RoundRobinStrategy);
        $sv1= new \Libreria\Servers\ServerOK("S1");
        $sv2= new \Libreria\Servers\ServerCaido("S2");
        $sv3= new \Libreria\Servers\ServerFail("S3");
        $sv4= new \Libreria\Servers\ServerNotFound("S4");
        $sv5= new \Libreria\Servers\ServerRedirect("S5");
        $lb->addServer($lb1);
        $lb->addServer($sv1);
        $lb->addServer($sv2);
        $lb1->addServer($sv3);
        $lb1->addServer($sv4);
        $this->assertEquals(500, $lb->call());
        $this->assertEquals(200, $lb->call());
        $this->assertEquals(0, $lb->call());
        $this->assertEquals(400, $lb->call());
        $this->assertEquals(200, $lb->call());
     }

     public function testListServer(){
        $lb=new \Libreria\LoadBalancer\GenericLoadBalancer("LB",
        new \Libreria\LoadBalancer\PickStrategy\RoundRobinStrategy);
        $sv= new \Libreria\Servers\ServerOK("Ok1");
        $lb->addServer($sv);
        $sv2= new \Libreria\Servers\ServerNotFound("NotF");
        $lb->addServer($sv2);

        $this-> assertContains($sv,$lb->getList());
        $this-> assertContains($sv2,$lb->getList());
    }
    public function testContarSV(){
        $lb=new \Libreria\LoadBalancer\GenericLoadBalancer("LB1",
        new \Libreria\LoadBalancer\PickStrategy\RoundRobinStrategy);
        $sv= new \Libreria\Estadistica(new \Libreria\Servers\ServerOK("Ok1"));
        $lb->addServer($sv);
        $this->assertEquals(200, $lb->call());
        $this->assertEquals(200, $lb->call());
        $this->assertEquals(200, $lb->call());
        $this->assertEquals(200, $lb->call());
        $this->assertEquals(4,$sv->count());
    }
    public function testContarDistintosServers(){
        $lb=new \Libreria\LoadBalancer\GenericLoadBalancer("LB1",
        new \Libreria\LoadBalancer\PickStrategy\RoundRobinStrategy);
        $sv= new \Libreria\Estadistica(new \Libreria\Servers\ServerOK("Ok1"));
        $sv1= new \Libreria\Estadistica(new \Libreria\Servers\ServerNotFound("fail"));
        $lb->addServer($sv);
        $lb->addServer($sv1);
        $this->assertEquals(200, $lb->call());
        $this->assertEquals(400, $lb->call());
        $this->assertEquals(1,$sv->count());
        $this->assertEquals(1,$sv1->count());
    }
}