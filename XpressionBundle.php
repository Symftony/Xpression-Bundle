<?php

namespace Symftony\XpressionBundle;

use Symftony\XpressionBundle\DependencyInjection\Compiler\ExpressionBuilderRegistryPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class XpressionBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ExpressionBuilderRegistryPass());
    }
}
