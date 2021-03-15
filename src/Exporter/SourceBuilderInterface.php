<?php
declare(strict_types=1);

namespace PBergman\Bundle\DoctrineExportBundle\Exporter;

use Sonata\Exporter\Source\SourceIteratorInterface;

interface SourceBuilderInterface
{
    public function getName(): string;

    public function getDescription(): string;

    public function getSourceIterator(): SourceIteratorInterface;
}