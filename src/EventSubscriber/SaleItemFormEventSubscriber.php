<?php

namespace Kematjaya\SaleBundle\EventSubscriber;

use Kematjaya\SaleBundle\Entity\SaleItemInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SaleItemFormEventSubscriber implements EventSubscriberInterface
{
    
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::SUBMIT => 'onSubmit'
        ];
    }
    
    public function onSubmit(FormEvent $event)
    {
        $data = $event->getData();
        if($data instanceof SaleItemInterface)
        {
            $data->setPrincipalPrice($data->getItem()->getPrincipalPrice());
        }
        
        $event->setData($data);
    }
}
