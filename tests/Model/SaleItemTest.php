<?php

namespace Kematjaya\SaleBundle\Tests\Model;

use Kematjaya\SaleBundle\Entity\SaleItemInterface;
use Kematjaya\ItemPack\Lib\Item\Entity\ItemInterface;
use Kematjaya\SaleBundle\Entity\SaleInterface;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SaleItemTest implements SaleItemInterface
{
    /**
     * 
     * @var ItemInterface
     */
    private $item;
    
    /**
     * 
     * @var SaleInterface
     */
    private $sale;
    
    /**
     * 
     * @var float
     */
    private $quantity;
    
    /**
     * 
     * @var float
     */
    private $principalPrice;
    
    /**
     * 
     * @var float
     */
    private $salePrice;
    
    /**
     * 
     * @var float
     */
    private $subTotal;
    
    /**
     * 
     * @var float
     */
    private $tax;
    
    /**
     * 
     * @var float
     */
    private $discount;
    
    /**
     * 
     * @var float
     */
    private $total;
    
    public function getItem(): ItemInterface {
        return $this->item;
    }

    public function getSale(): SaleInterface {
        return $this->sale;
    }

    public function getQuantity(): float {
        return $this->quantity;
    }

    public function getPrincipalPrice(): float {
        return $this->principalPrice;
    }

    public function getSalePrice(): float {
        return $this->salePrice;
    }

    public function getSubTotal(): float {
        return $this->subTotal;
    }

    public function getTax(): float {
        return $this->tax;
    }

    public function getDiscount(): float {
        return $this->discount;
    }

    public function getTotal(): float {
        return $this->total;
    }

    public function setItem(?ItemInterface $item): SaleItemInterface {
        $this->item = $item;
        return $this;
    }

    public function setSale(?SaleInterface $sale): SaleItemInterface {
        $this->sale = $sale;
        return $this;
    }

    public function setQuantity(float $quantity): SaleItemInterface {
        $this->quantity = $quantity;
        return $this;
    }

    public function setPrincipalPrice(float $principalPrice):SaleItemInterface {
        $this->principalPrice = $principalPrice;
        return $this;
    }

    public function setSalePrice(float $salePrice):SaleItemInterface {
        $this->salePrice = $salePrice;
        return $this;
    }

    public function setSubTotal(float $subTotal):SaleItemInterface {
        $this->subTotal = $subTotal;
        return $this;
    }

    public function setTax(float $tax):SaleItemInterface {
        $this->tax = $tax;
        return $this;
    }

    public function setDiscount(float $discount):SaleItemInterface {
        $this->discount = $discount;
        return $this;
    }

    public function setTotal(float $total):SaleItemInterface 
    {
        $this->total = $total;
        return $this;
    }
}
