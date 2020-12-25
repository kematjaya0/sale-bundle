<?php

namespace Kematjaya\SaleBundle\Fixtures;

use Kematjaya\SaleBundle\Repo\CustomerRepoInterface;
use Faker\Factory;
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
        for($i = 1; $i <=10; $i++)
        {
            $faker = Factory::create();
            $customer = $this->customerRepo->createCustomer();
            $customer->setCode($faker->creditCardNumber)
                    ->setName($faker->name)
                    ->setAddress($faker->address)
                    ->setPhone($faker->phoneNumber)
                    ->setMail($faker->email);
            
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
