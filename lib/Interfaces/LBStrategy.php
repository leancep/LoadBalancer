<?php
namespace Libreria\Interfaces;

interface LBStrategy{
    public function pick(array $servers);// ULTIMOS DOS PARAMETROS CAMBIAN SEGUN ESTRATEGIA
}