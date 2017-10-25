<?php

namespace Xo\GameBundle\Entity;

class LobbyPlayer {
    
    private $login = null;
    private $timestamp = null;
    
    public function __construct($login, $timestamp) {
        $this->login = $login;
        $this->timestamp = $timestamp;
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
    
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

}