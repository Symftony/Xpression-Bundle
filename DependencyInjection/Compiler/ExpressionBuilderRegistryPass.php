<?php

namespace Symftony\XpressionBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ExpressionBuilderRegistryPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     * @return mixed
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('xpression.expression_registry')) {
            return;
        }

        $expressionRegistryDefinition = $container->getDefinition('xpression.expression_registry');

        $serviceIds = $container->findTaggedServiceIds('expression_builder');
        foreach ($serviceIds as $serviceId => $tags) {
            foreach ($tags as $tag) {
                $expressionRegistryDefinition->addMethodCall('add', [new Reference($serviceId), $tag['alias']]);
            }
        }
    }
}