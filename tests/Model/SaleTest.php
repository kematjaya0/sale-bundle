<?php

namespace Kematjaya\SaleBundle\Tests\Model;

use Kematjaya\SaleBundle\Entity\SaleItemInterface;
use Kematjaya\SaleBundle\Entity\SaleInterface;
use Kematjaya\SaleBundle\Entity\CustomerInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SaleTest implements SaleInterface
{
    /**
     * 
     * @var string
     */
    private $code;
    
    /**
     * 
     * @var CustomerInterface
     */
    private $customer;
    
    /**
     * 
     * @var \DateTimeInterface
     */
    private $createdAt;
    
    /**
     * 
     * @var string
     */
    private $createdBy;
    
    /**
     * 
     * @var float
     */
    private $subTotal;
    
    /**
     * 
     * @var float
     */
    private $discount;
    
    /**
     * 
     * @var float
     */
    private $tax;
    
    /**
     * 
     * @var float
     */
    private $total;
    
    /**
     * 
     * @var float
     */
    private $payment;
    
    /**
     * 
     * @var float
     */
    private $paymentChange;
    
    /**
     * 
     * @var bool
     */
    private $isLocked;
    
    /**
     * 
     * @var Collection
     */
    private $saleItems;
    
    public function __construct() 
    {
        $this->saleItems = new ArrayCollection();
    }
    
    public function getCode(): string 
    {
        return $this->code;
    }

    public function getCustomer(): CustomerInterface 
    {
        return $this->customer;
    }

    public function getCreatedAt(): \DateTimeInterface 
    {
        return $this->createdAt;
    }

    public function getCreatedBy(): string 
    {
        return $this->createdBy;
    }

    public function getSubTotal(): ?float 
    {
        return $this->subTotal;
    }

    public function getDiscount(): ?float 
    {
        return $this->discount;
    }

    public function getTax(): ?float 
    {
        return $this->tax;
    }

    public function getTotal(): ?float 
    {
        return $this->total;
    }

    public function getPayment(): ?float 
    {
        return $this->payment;
    }

    public function getPaymentChange(): ?float 
    {
        return $this->paymentChange;
    }

    public function getIsLocked(): ?bool 
    {
        return $this->isLocked;
    }

    public function setCode(string $code) :SaleInterface
    {
        $this->code = $code;
        
        return $this;
    }

    public function setCustomer(?CustomerInterface $customer): SaleInterface
    {
        $this->customer = $customer;
        
        return $this;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt) : SaleInterface
    {
        $this->createdAt = $createdAt;
        
        return $this;
    }

    public function setCreatedBy(string $createdBy): SaleInterface 
    {
        $this->createdBy = $createdBy;
        
        return $this;
    }

    public function setSubTotal(float $subTotal): SaleInterface 
    {
        $this->subTotal = $subTotal;
        
        return $this;
    }

    public function setDiscount(float $discount): SaleInterface 
    {
        $this->discount = $discount;
        
        return $this;
    }

    public function setTax(float $tax):SaleInterface
    {
        $this->tax = $tax;
        
        return $this;
    }

    public function setTotal(float $total): SaleInterface 
    {
        $this->total = $total;
        
        return $this;
    }

    public function setPayment(float $payment): SaleInterface 
    {
        $this->payment = $payment;
        
        return $this;
    }

    public function setPaymentChange(float $paymentChange):SaleInterface 
    {
        $this->paymentChange = $paymentChange;
        
        return $this;
    }

    public function setIsLocked(bool $isLocked): SaleInterface 
    {
        $this->isLocked = $isLocked;
        
        return $this;
    }

    public function getSaleItems(): Collection 
    {
        return $this->saleItems;
    }
    
    public function addSaleItems(SaleItemInterface $item):self
    {
        $this->saleItems->add($item);
        
        return $this;
    }
}
