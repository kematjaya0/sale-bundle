<?php

namespace Kematjaya\SaleBundle\EventSubscriber;

use Kematjaya\SaleBundle\Entity\SaleInterface;
use Kematjaya\HiddenTypeBundle\Type\HiddenDateTimeType;
use Kematjaya\Currency\Type\PriceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\PropertyInfo\PropertyInfoExtractorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SaleFormEventSubscriber implements EventSubscriberInterface
{
    
    /**
     * 
     * @var PropertyInfoExtractorInterface
     */
    private $propertyInfoExtractor;
    
    /**
     * 
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    
    public function __construct(PropertyInfoExtractorInterface $propertyInfoExtractor, TokenStorageInterface $tokenStorage) 
    {
        $this->propertyInfoExtractor = $propertyInfoExtractor;
        $this->tokenStorage = $tokenStorage;
    }
    
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::SUBMIT => 'onSubmit'
        ];
    }
    
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        if(!$data instanceof SaleInterface) {
            return;
        }
        
        $form = $event->getForm();
        $form
            ->add('created_by', HiddenType::class)
            ->add('created_at', HiddenDateTimeType::class);

        $typePrice = ['sub_total', 'tax', 'discount', 'payment', 'payment_change', 'total'];
        foreach($typePrice as $name) {
            $attr = $form->get($name)->getConfig()->getOption('attr');
            $attr['class'] = (isset($attr['class'])) ? $attr['class'] .' priceformat': 'priceformat';

            $form->add($name, PriceType::class, ['attr' => $attr, 'label' => $name]);
        }

        if(!$data->getIsLocked()) {
            if($data->getSaleItems()->isEmpty()) {
                $form->add('is_locked', HiddenType::class);
            }
            
            return;
        }
        
        $form
            ->add('code', null, ['attr' => ['readonly' => true]])
            ->add('customer', null, ['attr' => ['readonly' => true]])
            ->add('is_locked', HiddenType::class);
    }
    
    public function onSubmit(FormEvent $event)
    {
        $data = $event->getData();
        if(!$data instanceof SaleInterface) {
            return;
        }
        
        $data->setCreatedBy($this->tokenStorage->getToken()->getUsername());
        if(is_null($data->getIsLocked())) {
            $data->setIsLocked(false);
        }

        $event->setData($data);
    }
    
}
