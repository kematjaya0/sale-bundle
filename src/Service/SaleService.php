<?php

namespace Kematjaya\SaleBundle\Service;

use Kematjaya\SaleBundle\Entity\SaleInterface;
use Kematjaya\SaleBundle\Entity\SaleItemInterface;
use Kematjaya\SaleBundle\Repo\SaleRepoInterface;
use Kematjaya\ItemPack\Service\StockServiceInterface;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SaleService 
{
    protected $saleRepo, $stockService;
    
    function __construct(SaleRepoInterface $saleRepo, StockServiceInterface $stockService) 
    {
        $this->saleRepo = $saleRepo;
        $this->stockService = $stockService;
    }
    
    public function update(SaleInterface $entity)
    {
        if($entity->getIsLocked())
        {
            $subTotal = 0;
            foreach($entity->getSaleItems() as $saleItem)
            {
                
                if($saleItem instanceof SaleItemInterface)
                {
                    $subTotal += $saleItem->getTotal();
                    $this->stockService->getStock($saleItem->getItem(), $saleItem->getQuantity());
                }
            }
            
            $total = $subTotal + $entity->getTax();
            
            $entity->setSubTotal($subTotal);
            $entity->setTotal($total);
            
            $this->saleRepo->save($entity);
            return $entity;
        }
        
    }
}
