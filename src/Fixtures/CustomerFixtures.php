<?php

namespace Kematjaya\SaleBundle\Fixtures;

use Kematjaya\SaleBundle\Repo\CustomerRepoInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class CustomerFixtures extends Fixture implements FixtureGroupInterface
{
    
    private $customerRepo;
    
    const CUSTOMER_REFERENCE = 'customer';
    
    public function __construct(CustomerRepoInterface $customerRepo) 
    {
        $this->customerRepo = $customerRepo;
    }
    
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <=10; $i++) {
            $customer = $this->customerRepo->createCustomer();
            $customer->setCode(rand())
                    ->setName("Customer " . $i)
                    ->setAddress("Jl xxx No 17")
                    ->setPhone("0856465648" . $i)
                    ->setMail(sprintf("test%s@gmail.com", $i));
            
            $manager->persist($customer);
            $this->setReference(self::CUSTOMER_REFERENCE, $customer);
        }
        
        $manager->flush();
    }
    
    public static function getGroups(): array
    {
        return [
            'kmj-sale'
        ];
    }
}
