<?php

namespace Kematjaya\SaleBundle\EventListener;

use Kematjaya\SaleBundle\Service\SaleServiceInterface;
use Kematjaya\SaleBundle\Entity\SaleInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SaleEventListener 
{
    
    /**
     * 
     * @var SaleServiceInterface
     */
    private $saleService;
    
    public function __construct(SaleServiceInterface $saleService) 
    {
        $this->saleService = $saleService;
    }
    
    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
        
        foreach ($uow->getScheduledEntityInsertions() as $entity) 
        {
            if(!$entity instanceof SaleInterface) {
                continue;
            }
            
            $this->updateSale($entity);
        }
        
        foreach ($uow->getScheduledEntityUpdates() as $entity) 
        {
            if(!$entity instanceof SaleInterface) {
                continue;
            }
            
            $this->updateSale($entity);
        }
        
        foreach($uow->getScheduledEntityDeletions() as $entity) 
        {
            if(!$entity instanceof SaleInterface) {
                continue;
            }
            
            $this->updateSale($entity);
        }
    }
    
    private function updateSale(SaleInterface $entity)
    {
        $this->saleService->update($entity);
    }
}
