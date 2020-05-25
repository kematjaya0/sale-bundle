<?php

namespace Kematjaya\SaleBundle\Service;

use Kematjaya\SaleBundle\Entity\SaleInterface;
use Kematjaya\SaleBundle\Entity\SaleItemInterface;
use Kematjaya\ItemPack\Service\StockServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SaleService 
{
    protected $entityManager, $stockService;
    
    function __construct(EntityManagerInterface $entityManager, StockServiceInterface $stockService) 
    {
        $this->entityManager = $entityManager;
        $this->stockService = $stockService;
    }
    
    protected function doPersist($entity, ?array $propertyChange)
    {
        $uow = $this->entityManager->getUnitOfWork();
        if(!empty($propertyChange))
        {
            foreach($propertyChange as $k => $v)
            {
                $uow->propertyChanged($entity, $k, $v[0], $v[1]);
            }
            
        }
        $this->entityManager->persist($entity);
        if(empty($propertyChange))
        {
            $classMetadata = $this->entityManager->getClassMetadata(get_class($entity));
            $uow->computeChangeSet($classMetadata, $entity);
        }
        
        return $entity;
    }
    
    public function update(SaleInterface $entity)
    {
        $propertyChange = [];
        if($entity->getIsLocked())
        {
            $subTotal = 0;
            foreach($entity->getSaleItems() as $saleItem)
            {
                
                if($saleItem instanceof SaleItemInterface)
                {
                    $subTotal += $saleItem->getTotal();
                    //$this->stockService->updateStock($purchaseDetail->getItem(), $purchaseDetail->getQuantity(), $purchaseDetail->getPackaging());
                }
            }
            //dump($saleItem);exit;
            $total = $subTotal + $entity->getTax();
            
            $uow = $this->entityManager->getUnitOfWork();
            $propertyChange = $uow->getEntityChangeSet($entity);
            $propertyChange['sub_total'] = [$entity->getSubTotal(), $subTotal];
            $propertyChange['total'] = [$entity->getTotal(), $total];
            
            $entity->setSubTotal($subTotal);
            $entity->setTotal($total);
            
            return $this->doPersist($entity, $propertyChange);
        }
        
    }
}
