<?php

namespace Xo\GameBundle\Entity;

class User {
    
    private $login = null;
    private $hash = null;
    
    public function __construct($login, $hash)
    {
        $this->login = $login;
        $this->hash = $hash;
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
    
}