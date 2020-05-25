<?php

namespace Kematjaya\SaleBundle\Repo;

use Kematjaya\SaleBundle\Entity\CustomerInterface;
use Doctrine\Common\Persistence\ObjectRepository;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface CustomerRepoInterface extends ObjectRepository
{
    public function createCustomer():CustomerInterface;
}
