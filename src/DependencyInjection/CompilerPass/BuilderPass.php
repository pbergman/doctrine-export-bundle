<?php
declare(strict_types=1);

namespace PBergman\Bundle\DoctrineExportBundle\DependencyInjection\CompilerPass;

use PBergman\Bundle\DoctrineExportBundle\Exporter\SourceBuilderManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class BuilderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition(SourceBuilderManager::class);

        foreach (array_keys($container->findTaggedServiceIds('pbergman_source_iterator.builder')) as $service) {
            $definition->addMethodCall('add', [new Reference($service)]);
        }
    }
}
