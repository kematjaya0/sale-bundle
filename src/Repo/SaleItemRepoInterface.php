<?php

namespace Kematjaya\SaleBundle\Repo;

use Kematjaya\SaleBundle\Entity\SaleInterface;
use Kematjaya\SaleBundle\Entity\SaleItemInterface;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface SaleItemRepoInterface 
{
    public function createSaleItem(SaleInterface $sale):SaleItemInterface;
    
    public function save(SaleItemInterface $saleItem): void;
}
