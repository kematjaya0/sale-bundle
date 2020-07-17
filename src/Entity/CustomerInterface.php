<?php

namespace Kematjaya\SaleBundle\Entity;

use Doctrine\Common\Collections\Collection;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface CustomerInterface 
{
    public function getCode(): ?string;

    public function setCode(string $code): self;

    public function getName(): ?string;

    public function setName(string $name): self;

    public function getAddress(): ?string;

    public function setAddress(string $address): self;

    public function getPhone(): ?string;

    public function setPhone(?string $phone): self;

    public function getMail(): ?string;

    public function setMail(?string $mail): self;
    
    public function getSales(): Collection;
}
