<?php

namespace Kematjaya\SaleBundle\Repo;

use Kematjaya\SaleBundle\Entity\CustomerInterface;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface CustomerRepoInterface
{
    public function createCustomer():CustomerInterface;
}
