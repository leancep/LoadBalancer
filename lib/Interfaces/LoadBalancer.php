<?php
namespace Libreria\Interfaces;

interface LoadBalancer{
    public function addServer(Server $server);
    public function removeServer(string $serverName);
}