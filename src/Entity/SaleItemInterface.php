<?php

namespace Kematjaya\SaleBundle\Entity;

use Kematjaya\ItemPack\Lib\Item\Entity\ItemInterface;
use Kematjaya\SaleBundle\Entity\SaleInterface;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface SaleItemInterface 
{
    public function getItem(): ?ItemInterface;

    public function setItem(?ItemInterface $item): self;

    public function getSale(): ?SaleInterface;

    public function setSale(?SaleInterface $sale): self;

    public function getQuantity(): ?float;

    public function setQuantity(float $quantity): self;

    public function getPrincipalPrice(): ?float;

    public function setPrincipalPrice(float $principal_price): self;

    public function getSalePrice(): ?float;

    public function setSalePrice(float $sale_price): self;

    public function getTax(): ?float;

    public function setTax(float $tax): self;

    public function getSubTotal(): ?float;

    public function setSubTotal(float $sub_total): self;

    public function getTotal(): ?float;

    public function setTotal(float $total): self;
}
