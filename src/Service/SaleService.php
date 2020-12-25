<?php

namespace Kematjaya\SaleBundle\Service;

use Kematjaya\SaleBundle\Entity\SaleInterface;
use Kematjaya\SaleBundle\Entity\SaleItemInterface;
use Kematjaya\SaleBundle\Repo\SaleRepoInterface;
use Kematjaya\SaleBundle\Repo\SaleItemRepoInterface;
use Kematjaya\ItemPack\Service\StockServiceInterface;
use Kematjaya\ItemPack\Service\StockCardServiceInterface;
use Kematjaya\ItemPack\Lib\Stock\Entity\ClientStockCardInterface;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SaleService implements SaleServiceInterface
{
    /**
     * 
     * @var SaleRepoInterface
     */
    private $saleRepo;
    
    /**
     * 
     * @var StockServiceInterface
     */
    private $stockService;
    
    /**
     * 
     * @var StockCardServiceInterface
     */
    private $stockCardService;
    
    /**
     * 
     * @var SaleItemRepoInterface
     */
    private $saleItemRepo;
    
    function __construct(SaleRepoInterface $saleRepo, SaleItemRepoInterface $saleItemRepo, StockServiceInterface $stockService, StockCardServiceInterface $stockCardService) 
    {
        $this->saleRepo = $saleRepo;
        $this->stockService = $stockService;
        $this->stockCardService = $stockCardService;
        $this->saleItemRepo = $saleItemRepo;
    }
    
    public function update(SaleInterface $entity): SaleInterface
    {
        if(!$entity->getIsLocked()) {
            return $entity;
        }
            
        $this->updatePaymentChange($entity);
        
        $this->saleRepo->save($entity);
        
        return $entity;
    }
    
    public function countSubTotal(SaleInterface $entity):float
    {
        $subTotal = 0;
        foreach($entity->getSaleItems() as $saleItem) {
            if(!$saleItem instanceof SaleItemInterface) {
                continue;
            }
            
            $itemSubTotal = $saleItem->getQuantity() * $saleItem->getSalePrice();
            $total = ($itemSubTotal + $saleItem->getTax()) - $saleItem->getDiscount();
            $saleItem->setTotal($total);
            $this->saleItemRepo->save($saleItem);
            
            $subTotal += $total;

            $item = $this->stockService->getStock($saleItem->getItem(), $saleItem->getQuantity());
            if($saleItem instanceof ClientStockCardInterface) {
                $this->stockCardService->insertStockCard($item, $saleItem);
            }
        }
        
        return $subTotal;
    }
    
    public function updatePaymentChange(SaleInterface $entity): SaleInterface
    {
        $subTotal = $this->countSubTotal($entity);
        
        $tax        = null !== $entity->getTax() ? $entity->getTax() : 0;
        $discount   = null !== $entity->getDiscount() ? $entity->getDiscount() : 0;
        $payment    = null !== $entity->getPayment() ? $entity->getPayment() : 0;
        $total      = ($subTotal + $tax) - $discount;
        $paymentChange = $payment - $total;
        
        $entity->setSubTotal($subTotal);
        $entity->setTotal($total);
        $entity->setPaymentChange($paymentChange);
        
        return $entity;
    }
}
