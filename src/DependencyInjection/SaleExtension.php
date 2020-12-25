<?php

namespace Kematjaya\SaleBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SaleExtension extends Extension 
{
    public function load(array $configs, ContainerBuilder $container) 
    {
        $loader = new YamlFileLoader($container, 
                new FileLocator(dirname(__DIR__). DIRECTORY_SEPARATOR . 'Resources/config'));
        $loader->load('services.yml');
    }
}
