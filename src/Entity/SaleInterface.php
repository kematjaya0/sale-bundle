<?php

namespace Kematjaya\SaleBundle\Entity;

use Kematjaya\SaleBundle\Entity\CustomerInterface;
use Doctrine\Common\Collections\Collection;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface SaleInterface 
{
    public function getCode(): ?string;

    public function setCode(string $code): self;

    public function getCreatedAt(): ?\DateTimeInterface;

    public function setCreatedAt(\DateTimeInterface $created_at): self;

    public function getCreatedBy(): ?string;

    public function setCreatedBy(string $created_by): self;

    public function getTotal(): ?float;

    public function setTotal(float $total): self;

    public function getSubTotal(): ?float;

    public function setSubTotal(float $sub_total): self;

    public function getTax(): ?float;

    public function setTax(float $tax): self;

    public function getIsLocked(): ?bool;

    public function setIsLocked(bool $is_locked): self;

    public function getCustomer(): ?CustomerInterface;

    public function setCustomer(?CustomerInterface $customer): self;
    
    public function getSaleItems(): Collection;
}
