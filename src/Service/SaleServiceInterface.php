<?php

namespace Kematjaya\SaleBundle\Service;

use Kematjaya\SaleBundle\Entity\SaleInterface;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface SaleServiceInterface 
{
    public function update(SaleInterface $entity): SaleInterface;
    
    public function countSubTotal(SaleInterface $entity):float;
    
    public function updatePaymentChange(SaleInterface $entity): SaleInterface;
}
