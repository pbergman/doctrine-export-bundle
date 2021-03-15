<?php
declare(strict_types=1);

namespace PBergman\Bundle\DoctrineExportBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('p_bergman_doctrine_export');

        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->info('Predefined export queries.')
            ->normalizeKeys(false)
            ->useAttributeAsKey('name', false)
            ->arrayPrototype()
                ->children()
                    ->scalarNode('name')->isRequired()->end()
                    ->scalarNode('connection')->defaultValue('default')->end()
                    ->scalarNode('description')->end()
                    ->scalarNode('query')->isRequired()->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}