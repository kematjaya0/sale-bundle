<?php

namespace Kematjaya\SaleBundle\Tests;

use Kematjaya\SaleBundle\Tests\Model\SaleTest;
use Kematjaya\SaleBundle\Tests\Model\SaleItemTest;
use Kematjaya\SaleBundle\Tests\Model\ItemTest;
use Kematjaya\SaleBundle\Service\SaleServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SaleBundleTest extends WebTestCase
{
    public static function getKernelClass() 
    {
        return AppKernelTest::class;
    }
    
    protected function buildProduct(): ItemTest
    {
        $product = new ItemTest();
        $product->setCode('test')
                ->setName('Test')
                ->setLastPrice(1200)
                ->setPrincipalPrice(1000)
                ->setLastStock(30)
                ;
        $package = (new Model\PackagingTest())->setCode('test')->setName('Test');
        $productPackage = new Model\ItemPackageTest();
        $productPackage->setItem($product)
                ->setPackaging($package)
                ->setPrincipalPrice($product->getPrincipalPrice())
                ->setQuantity(1)
                ->setSalePrice($product->getLastPrice());

        $product->addItemPackage($productPackage);
        
        return $product;
    }
    
    protected function getContainer(): ContainerInterface
    {
        $client = parent::createClient();
        return $client->getContainer();
    }
    
    public function testInstance(): SaleServiceInterface
    {
        $container = $this->getContainer();
        $this->assertTrue($container->has('kematjaya.sale_service'));
        $this->assertInstanceOf(SaleServiceInterface::class, $container->get('kematjaya.sale_service'));
        
        return $container->get('kematjaya.sale_service');
    }
    
    /**
     * @depends testInstance
     */
    public function testUpdateNotLocked(SaleServiceInterface $service)
    {
        $entity = (new SaleTest())
                ->setIsLocked(false);
        
        $actual = $service->update($entity);
        $this->assertEquals($entity->getIsLocked(), $actual->getIsLocked());
    }
    
    /**
     * @depends testInstance
     */
    public function testUpdateIsLocked(SaleServiceInterface $service)
    {
        $entity = new SaleTest();
        $entity->setIsLocked(true);
        
        $actual = $service->update($entity);
        $this->assertEquals($entity->getIsLocked(), $actual->getIsLocked());
        $this->assertEquals($entity->getTotal(), $actual->getTotal());
        
        $subTotals = 0;
        for($i = 1; $i<= 5; $i++) {
            
            $product    = $this->buildProduct();
            $subTotal   = $i * $product->getLastPrice();
            $discount   = 0;
            $tax        = 0;
            $total      = $subTotal + $tax - $discount;
            $item = new SaleItemTest();
            $item->setDiscount($discount)
                    ->setItem($product)
                    ->setPrincipalPrice($product->getPrincipalPrice())
                    ->setQuantity($i)
                    ->setSale($entity)
                    ->setSalePrice($product->getLastPrice())
                    ->setSubTotal($subTotal)
                    ->setTax($tax)
                    ->setTotal($total);
            
            $subTotals += $total;
            $entity->addSaleItems($item);
        }
        
        $actual = $service->countSubTotal($entity);
        $this->assertEquals($subTotals, $actual);
        
        $change = $service->updatePaymentChange($entity);
        $this->assertEquals($subTotals, $change->getSubTotal());
        
        $payment = 20000;
        $entity->setPayment($payment);
        $change2 = $service->updatePaymentChange($entity);
        $this->assertEquals($payment - $subTotals, $change2->getPaymentChange());
        
        $actual2 = $service->update($entity);
        $this->assertEquals($payment - $subTotals, $actual2->getPaymentChange());
    }
}
