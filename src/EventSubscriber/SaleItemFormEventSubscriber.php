<?php

namespace Kematjaya\SaleBundle\EventSubscriber;

use Kematjaya\SaleBundle\Entity\SaleItemInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SaleItemFormEventSubscriber implements EventSubscriberInterface
{
    
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::SUBMIT => 'onSubmit',
            FormEvents::POST_SUBMIT => 'postSubmit'
        ];
    }
    
    public function onSubmit(FormEvent $event)
    {
        $data = $event->getData();
        if (!$data instanceof SaleItemInterface) {
            
            return;
        }
        
        $data->setPrincipalPrice($data->getItem()->getPrincipalPrice());
        
        $event->setData($data);
    }
    
    public function postSubmit(FormEvent $event)
    {
        $data = $event->getData();
        if(!$data instanceof SaleItemInterface) {
            return;
        }
        
        $item = $data->getItem();
        $form = $event->getForm();
        if($item->getLastStock() < $data->getQuantity()) {
            $form->get('quantity')
                    ->addError(new FormError(sprintf('not sufficient stock for product %s, available: %s', $item->getName(), $item->getLastStock())));
            return;
        }

        if($item->getLastPrice() <= 0) {
            $form->get('sale_price')
                    ->addError(new FormError(sprintf('price not set for item %s', $item->getName())));
            return;
        }

        if($item->getLastPrice() <= $item->getPrincipalPrice()) {
            $form->get('sale_price')
                    ->addError(new FormError(sprintf('sale price (%s) less than principal price (%s), please contact administrator.', $item->getLastPrice(), $item->getPrincipalPrice())));
            return;
        }
        
        $subTotal = $data->getQuantity() * $data->getSalePrice();
        $total = $subTotal + $data->getTax() - $data->getDiscount();
        $data->setSubTotal($subTotal);
        $data->setTotal($total);
        
        $event->setData($data);
    }
}
