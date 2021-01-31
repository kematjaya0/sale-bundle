<?php

namespace Kematjaya\SaleBundle\Tests\Repository;

use Kematjaya\SaleBundle\Tests\Model\SaleItemTest;
use Kematjaya\SaleBundle\Repo\SaleItemRepoInterface;
use Kematjaya\SaleBundle\Entity\SaleInterface;
use Kematjaya\SaleBundle\Entity\SaleItemInterface;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SaleItemRepository implements SaleItemRepoInterface
{
    
    public function createSaleItem(SaleInterface $sale): SaleItemInterface 
    {
        $item = new SaleItemTest();
        $item->setSale($sale);
        
        return $item;
    }

    public function save(SaleItemInterface $saleItem): void 
    {
        
    }

}
