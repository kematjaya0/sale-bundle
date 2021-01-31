<?php

namespace Kematjaya\SaleBundle\Tests\Model;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class TokenStorageTest implements TokenStorageInterface
{
    
    /**
     * 
     * @var TokenInterface
     */
    private $token;
    
    public function getToken() 
    {
        return $this->token;
    }

    public function setToken(TokenInterface $token = null) 
    {
        $this->token = $token;
    }

}
