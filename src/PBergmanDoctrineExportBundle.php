<?php
declare(strict_types=1);

namespace PBergman\Bundle\DoctrineExportBundle;

use PBergman\Bundle\DoctrineExportBundle\DependencyInjection\CompilerPass\BuilderPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PBergmanDoctrineExportBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new BuilderPass());
    }
}
