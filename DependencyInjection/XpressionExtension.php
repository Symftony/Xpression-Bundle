<?php

namespace Symftony\XpressionBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class XpressionExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        if (class_exists('Doctrine\Common\Collections\ExpressionBuilder')) {
            $loader->load('services/common.yml');
        }

        if (class_exists('Doctrine\MongoDB\Query\Expr')) {
            $loader->load('services/odm.yml');
        }

        if (class_exists('Doctrine\ORM\Query\Expr')) {
            $loader->load('services/orm.yml');
        }
    }
}
