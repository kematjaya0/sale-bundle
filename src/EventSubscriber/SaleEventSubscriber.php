<?php

namespace Kematjaya\SaleBundle\EventSubscriber;

use Kematjaya\SaleBundle\Entity\SaleInterface;
use Kematjaya\SaleBundle\Service\SaleService;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SaleEventSubscriber implements EventSubscriber
{
    
    private $saleService;
    
    public function __construct(SaleService $saleService) 
    {
        $this->saleService = $saleService;
    }
    
    public function getSubscribedEvents() {
        return [
            Events::onFlush
        ];
    }
    
    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
        
        foreach ($uow->getScheduledEntityInsertions() as $entity) 
        {
            if($entity instanceof SaleInterface) {
                $this->updateSale($entity);
            }
        }
        
        foreach ($uow->getScheduledEntityUpdates() as $entity) 
        {
            if($entity instanceof SaleInterface) {
                $this->updateSale($entity);
            }
        }
        
        foreach($uow->getScheduledEntityDeletions() as $entity) 
        {
            if($entity instanceof SaleInterface) {
                $this->updateSale($entity);
            }
        }
    }
    
    private function updateSale(SaleInterface $entity)
    {
        $this->saleService->update($entity);
    }
}
