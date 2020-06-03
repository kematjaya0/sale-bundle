<?php

namespace Kematjaya\SaleBundle\EventSubscriber;

use Kematjaya\SaleBundle\Entity\SaleItemInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SaleItemFormEventSubscriber implements EventSubscriberInterface
{
    private $translator;
    
    public function __construct(TranslatorInterface $translator) 
    {
        $this->translator = $translator;
    }
    
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
        if($data instanceof SaleItemInterface)
        {
            $data->setPrincipalPrice($data->getItem()->getPrincipalPrice());
        }
        
        $event->setData($data);
    }
    
    public function postSubmit(FormEvent $event)
    {
        $data = $event->getData();
        if($data instanceof SaleItemInterface)
        {
            $item = $data->getItem();
            $form = $event->getForm();
            if($item->getLastStock() < $data->getQuantity())
            {
                $form->get('quantity')->addError(new FormError($this->translator->trans('stock_tidak_cukup').', Max: '. $item->getLastStock()));
                return;
            }
            
            if($item->getLastPrice() <= 0)
            {
                $form->get('sale_price')->addError(new FormError($this->translator->trans('sale_price_null')));
                return;
            }
            
            if($item->getLastPrice() <= $item->getPrincipalPrice())
            {
                $form->get('sale_price')->addError(new FormError($this->translator->trans('sale_price_less_than_principal_price')));
            }
        }
    }
}
