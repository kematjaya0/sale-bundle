<?php

namespace Kematjaya\SaleBundle\EventSubscriber;

use Kematjaya\SaleBundle\Entity\SaleInterface;
use Kematjaya\SaleBundle\Form\Type\HiddenDateTimeType;
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
    private $propertyInfoExtractor, $tokenStorage;
    
    public function __construct(
            PropertyInfoExtractorInterface $propertyInfoExtractor, 
            TokenStorageInterface $tokenStorage) 
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
        if($data instanceof SaleInterface)
        {
            $camelToSnakeCase = function ($input)
            {
                preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
                $ret = $matches[0];
                foreach ($ret as &$match) {
                  $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
                }
                return implode('_', $ret);  
            };
            $form = $event->getForm();
            $form
                ->add('created_by', HiddenType::class)
                ->add('created_at', HiddenDateTimeType::class);
            
            $typePrice = ['sub_total', 'tax', 'total'];
            foreach($typePrice as $name)
            {
                $attr = $form->get($name)->getConfig()->getOption('attr');
                $attr['readonly'] = true;
                $attr['class'] = (isset($attr['class'])) ? $attr['class'] .' priceformat': 'priceformat';
                
                $form->add($name, PriceType::class, ['attr' => $attr, 'label' => $name]);
            }
            
            if($data->getIsLocked())
            {
                $form
                    ->add('code', null, ['attr' => ['readonly' => true]])
                    ->add('customer', null, ['attr' => ['readonly' => true]])
                    ->add('is_locked', HiddenType::class);
            } else
            {
                if($data->getSaleItems()->isEmpty())
                {
                    $form->add('is_locked', HiddenType::class);
                }
            }
        }
    }
    
    public function onSubmit(FormEvent $event)
    {
        $data = $event->getData();
        if($data instanceof SaleInterface)
        {
            $data->setCreatedBy($this->tokenStorage->getToken()->getUsername());
            if(is_null($data->getIsLocked()))
            {
                $data->setIsLocked(false);
            }
            
            $event->setData($data);
        }
    }
    
}
