<?php

namespace Kematjaya\SaleBundle\Tests\Repository;

use Kematjaya\SaleBundle\Repo\SaleRepoInterface;
use Kematjaya\SaleBundle\Entity\SaleInterface;
use Kematjaya\SaleBundle\Tests\Model\SaleTest;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SaleRepository implements SaleRepoInterface
{
    
    public function createSale(): SaleInterface 
    {
        return new SaleTest();
    }

    public function save(SaleInterface $sale): void 
    {
        
    }

}
