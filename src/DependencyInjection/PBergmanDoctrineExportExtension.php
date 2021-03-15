<?php
declare(strict_types=1);

namespace PBergman\Bundle\DoctrineExportBundle\DependencyInjection;

use PBergman\Bundle\DoctrineExportBundle\Exporter\WrappedSourceIterator;
use Sonata\Exporter\Source\DoctrineDBALConnectionSourceIterator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class PBergmanDoctrineExportExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(dirname(__FILE__ , 2). '/Resources/config'));
        $loader->load('services.xml');
        $config = $this->processConfiguration(new Configuration(), $configs);

        foreach ($config as $name => $cnf) {
            $container->setDefinition('pbergman_source_iterator.builder_' . $name,
                (new Definition(WrappedSourceIterator::class, [
                    $this->getDoctrineDBALConnectionSourceIterator($name, $cnf, $container),
                    $name,
                    $cnf['description'],
                ]))
                    ->setPublic(false)
                    ->addTag('pbergman_source_iterator.builder')
            );
        }
    }

    private function getDoctrineDBALConnectionSourceIterator(string $name, array $cnf, ContainerBuilder $container): Reference
    {
        $source = (new Definition(DoctrineDBALConnectionSourceIterator::class, [
                new Reference('doctrine.dbal.' . $cnf['connection'] . '_connection'),
                $cnf['query']
            ]))
            ->setPublic(false);

        $id = 'pbergman_source_iterator.query_' .  $name;
        $container->setDefinition($id, $source);
        return new Reference($id);
    }

}