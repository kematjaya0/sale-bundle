<?php

namespace Kematjaya\SaleBundle\Repo;

use Kematjaya\SaleBundle\Entity\SaleInterface;
use Doctrine\Common\Persistence\ObjectRepository;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface SaleRepoInterface extends ObjectRepository 
{
    public function createSale():SaleInterface;
    
    public function save(SaleInterface $sale): void;
}
