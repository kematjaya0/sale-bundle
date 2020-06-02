<?php

namespace Kematjaya\SaleBundle\Service;

use Kematjaya\SaleBundle\Entity\SaleInterface;
use Kematjaya\SaleBundle\Entity\SaleItemInterface;
use Kematjaya\SaleBundle\Repo\SaleRepoInterface;
use Kematjaya\ItemPack\Service\StockServiceInterface;
use Kematjaya\ItemPack\Service\StockCardServiceInterface;
use Kematjaya\ItemPack\Lib\Stock\Entity\ClientStockCardInterface;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SaleService 
{
    protected $saleRepo, $stockService, $stockCardService;
    
    function __construct(
            SaleRepoInterface $saleRepo, 
            StockServiceInterface $stockService,
            StockCardServiceInterface $stockCardService) 
    {
        $this->saleRepo = $saleRepo;
        $this->stockService = $stockService;
        $this->stockCardService = $stockCardService;
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
                    $item = $this->stockService->getStock($saleItem->getItem(), $saleItem->getQuantity());
                    if($saleItem instanceof ClientStockCardInterface) 
                    {
                        $stockCard = $this->stockCardService->insertStockCard($item, $saleItem);
                    }
                }
            }
            
            $total = $subTotal + $entity->getTax();
            
            $entity->setSubTotal($subTotal);
            $entity->setTotal($total);
            
        }
        
        $this->saleRepo->save($entity);
        return $entity;
    }
}
