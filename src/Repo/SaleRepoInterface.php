<?php

namespace Kematjaya\SaleBundle\Repo;

use Kematjaya\SaleBundle\Entity\SaleInterface;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface SaleRepoInterface
{
    public function createSale():SaleInterface;
    
    public function save(SaleInterface $sale): void;
}
